<?php

namespace Tests\Feature;

use App\Models\AuditTest;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TimesRestoredCorrectlyTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_time_restores_correctly()
    {
        $originalStart = new Carbon('2022-01-01 12:00:00');

        $auditTest = new AuditTest();
        $auditTest->start = $originalStart;
        $auditTest->end = new Carbon('2022-01-01 2:00:00');
        $auditTest->save();

        $auditTest = AuditTest::first();
        $auditTest->start = new Carbon('2022-01-01 12:30:00');
        $auditTest->save();

        $auditTest->transitionTo($auditTest->audits->last(), true);

        $this->assertEquals($auditTest->start, $originalStart);
    }
}
