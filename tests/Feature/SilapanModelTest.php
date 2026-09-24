<?php

namespace Tests\Feature;

use App\Enums\ClientType;
use App\Enums\InvoicePaymentStatus;
use App\Enums\MarketingAuthorization;
use App\Enums\RegistrationFeeCategory;
use App\Enums\RegistrationSamplingType;
use App\Enums\RegistrationStatus;
use App\Enums\RiskCategory;
use App\Enums\SampleConclusion;
use App\Enums\SampleForm;
use App\Enums\SampleStatus;
use App\Enums\SampleUnit;
use App\Enums\UserRole;
use App\Models\AuditLog;
use App\Models\Certificate;
use App\Models\Client;
use App\Models\FoodCategory;
use App\Models\FoodType;
use App\Models\InformationRequest;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Payment;
use App\Models\Registration;
use App\Models\RegistrationDocument;
use App\Models\Sample;
use App\Models\SampleParameter;
use App\Models\SampleRequirement;
use App\Models\TestParameter;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

class SilapanModelTest extends TestCase
{
    use DatabaseTransactions;

    public function test_can_create_and_relate_all_silapan_models(): void
    {
        // 1. User
        $user = User::factory()->create([
            'role' => UserRole::Admin,
        ]);
        $this->assertTrue(Str::isUuid($user->id));
        $this->assertEquals(UserRole::Admin, $user->role);
        $this->assertTrue($user->isAdmin());

        // 2. Client
        $client = Client::create([
            'user_id' => $user->id,
            'client_type' => ClientType::Business,
            'name' => 'PT Sumber Pangan Sehat',
            'institution_name' => 'PT Sumber Pangan Sehat',
            'address' => 'Jl. Tjilik Riwut Km 5, Palangka Raya',
            'phone' => '081234567890',
            'is_msme' => true,
        ]);
        $this->assertTrue(Str::isUuid($client->id));
        $this->assertEquals($user->id, $client->user->id);
        $this->assertEquals(ClientType::Business, $client->client_type);

        // 3. Food Category & Food Type
        $category = FoodCategory::create([
            'code' => '01',
            'name' => 'Produk Susu dan Analognya',
        ]);
        $this->assertTrue(Str::isUuid($category->id));

        $foodType = FoodType::create([
            'food_category_id' => $category->id,
            'name' => 'Susu Pasteurisasi',
            'default_risk_category' => RiskCategory::High,
            'is_active' => true,
        ]);
        $this->assertTrue(Str::isUuid($foodType->id));
        $this->assertEquals($category->id, $foodType->foodCategory->id);

        // 4. Test Parameter & Pivot
        $param = TestParameter::create([
            'code' => 'ALT-01',
            'name' => 'Angka Lempeng Total (ALT)',
            'result_unit' => 'koloni/g',
            'tariff' => 125000,
            'is_active' => true,
        ]);
        $this->assertTrue(Str::isUuid($param->id));
        $foodType->testParameters()->attach($param->id);
        $this->assertCount(1, $foodType->testParameters);

        // 5. Sample Requirement
        $requirement = SampleRequirement::create([
            'food_type_id' => $foodType->id,
            'sample_form' => SampleForm::Liquid,
            'min_units' => 10,
            'unit_size' => 500,
            'unit' => SampleUnit::Ml,
            'sampling_type' => RegistrationSamplingType::Targeted,
            'special_requirements' => ['suhu' => '4-8 C', 'segel' => 'utuh'],
            'is_active' => true,
        ]);
        $this->assertTrue(Str::isUuid($requirement->id));
        $this->assertEquals($foodType->id, $requirement->foodType->id);

        // 6. Registration & Documents
        $registration = Registration::create([
            'registration_number' => 'REG-2026-00001',
            'client_id' => $client->id,
            'sampling_type' => RegistrationSamplingType::Targeted,
            'fee_category' => RegistrationFeeCategory::PaidService,
            'status' => RegistrationStatus::Pending,
            'form_data' => ['keterangan' => 'Uji rutin berkala'],
            'registration_date' => now()->toDateString(),
        ]);
        $this->assertTrue(Str::isUuid($registration->id));
        $this->assertEquals($client->id, $registration->client->id);

        $document = RegistrationDocument::create([
            'registration_id' => $registration->id,
            'type' => 'surat_pengantar',
            'path' => 'documents/surat_pengantar.pdf',
            'file_name' => 'surat_pengantar.pdf',
            'mime' => 'application/pdf',
            'size_kb' => 256,
        ]);
        $this->assertTrue(Str::isUuid($document->id));
        $this->assertEquals($registration->id, $document->registration->id);

        // 7. Sample
        $sample = Sample::create([
            'sample_number' => 'SMP-2026-00001',
            'registration_id' => $registration->id,
            'food_type_id' => $foodType->id,
            'sample_name' => 'Susu Sapi Segar Barito',
            'brand' => 'Barito Fresh',
            'sample_form' => SampleForm::Liquid,
            'unit_count' => 10,
            'unit_size' => 500,
            'marketing_authorization' => MarketingAuthorization::MD,
            'authorization_number' => 'MD 123456789012',
            'risk_category' => RiskCategory::High,
            'purchase_price' => 150000,
            'extra_info' => ['wadah' => 'botol kaca'],
            'status' => SampleStatus::AwaitingSample,
        ]);
        $this->assertTrue(Str::isUuid($sample->id));
        $this->assertEquals($registration->id, $sample->registration->id);
        $this->assertEquals($foodType->id, $sample->foodType->id);

        // 8. Sample Parameter
        $sampleParameter = SampleParameter::create([
            'sample_id' => $sample->id,
            'test_parameter_id' => $param->id,
            'result_value' => '1.0 x 10^2',
            'unit' => 'koloni/g',
            'requirement_limit' => '< 5.0 x 10^4',
            'compliance_status' => SampleConclusion::Compliant,
            'analyzed_by' => $user->id,
            'tested_at' => now(),
        ]);
        $this->assertTrue(Str::isUuid($sampleParameter->id));
        $this->assertEquals($sample->id, $sampleParameter->sample->id);
        $this->assertEquals($param->id, $sampleParameter->testParameter->id);

        // 9. Invoice & Invoice Item
        $invoice = Invoice::create([
            'invoice_number' => 'INV-2026-00001',
            'registration_id' => $registration->id,
            'total' => 125000,
            'payment_status' => InvoicePaymentStatus::Unpaid,
            'issued_at' => now(),
        ]);
        $this->assertTrue(Str::isUuid($invoice->id));
        $this->assertEquals($registration->id, $invoice->registration->id);

        $invoiceItem = InvoiceItem::create([
            'invoice_id' => $invoice->id,
            'sample_parameter_id' => $sampleParameter->id,
            'description' => 'Biaya Pengujian Angka Lempeng Total (ALT)',
            'tariff' => 125000,
        ]);
        $this->assertTrue(Str::isUuid($invoiceItem->id));
        $this->assertEquals($invoice->id, $invoiceItem->invoice->id);

        // 10. Payment
        $payment = Payment::create([
            'invoice_id' => $invoice->id,
            'amount' => 125000,
            'paid_date' => now()->toDateString(),
            'reference' => 'TRX-987654321',
            'verified_by' => $user->id,
            'verified_at' => now(),
        ]);
        $this->assertTrue(Str::isUuid($payment->id));
        $this->assertEquals($invoice->id, $payment->invoice->id);

        // 11. Certificate
        $certificate = Certificate::create([
            'certificate_number' => 'CERT-2026-00001',
            'sample_id' => $sample->id,
            'conclusion' => SampleConclusion::Compliant,
            'file_path' => 'certificates/CERT-2026-00001.pdf',
            'issued_by' => $user->id,
            'issued_at' => now(),
        ]);
        $this->assertTrue(Str::isUuid($certificate->id));
        $this->assertEquals($sample->id, $certificate->sample->id);

        // 12. Information Request
        $infoRequest = InformationRequest::create([
            'user_id' => $user->id,
            'sample_id' => $sample->id,
            'keyword' => 'SMP-2026-00001',
        ]);
        $this->assertTrue(Str::isUuid($infoRequest->id));
        $this->assertEquals($sample->id, $infoRequest->sample->id);

        // 13. Polymorphic Status History
        $history = $sample->statusHistories()->create([
            'old_status' => 'awaiting_sample',
            'new_status' => 'received',
            'user_id' => $user->id,
            'notes' => 'Sampel diserahkan oleh klien dan diterima petugas loket',
        ]);
        $this->assertTrue(Str::isUuid($history->id));
        $this->assertEquals($sample->id, $history->statusable->id);

        // 14. Polymorphic Audit Log
        $audit = AuditLog::create([
            'user_id' => $user->id,
            'event' => 'sample_received',
            'auditable_type' => Sample::class,
            'auditable_id' => $sample->id,
            'old_values' => ['status' => 'awaiting_sample'],
            'new_values' => ['status' => 'received'],
            'ip_address' => '127.0.0.1',
        ]);
        $this->assertTrue(Str::isUuid($audit->id));
        $this->assertEquals($sample->id, $audit->auditable->id);
    }
}
