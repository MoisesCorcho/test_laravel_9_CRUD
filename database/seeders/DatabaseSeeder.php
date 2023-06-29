<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
       $this->call(RoleSeeder::class);
       $this->call(PermissionSeeder::class);
       $this->call(ReasonForNotVisitSeeder::class);
       $this->call(CreateSellerSuperAdminAndAdmin::class);
       $this->call(MemberPositionSeeder::class);
       $this->call(OrganizationsSeeder::class); //Falsas
       $this->call(OrganizationsSeeder2::class); //Datos reales
       $this->call(MemberSeeder::class);
       $this->call(SurveySeeder::class);
       $this->call(SurveyQuestionSeeder::class);
    //    $this->call(SurveyAnswerSeeder::class);
    //    $this->call(SurveyQuestionAnswerSeeder::class);
       $this->call(ResponsesFormSeeder::class);
       $this->call(VisitSeeder::class);
    }
}
