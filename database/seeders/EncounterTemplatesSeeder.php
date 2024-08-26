<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EncounterTemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('encounter_templates')->insert([
            [
                'id' => 1,
                'provider_id' => null,
                'patient_id' => null,
                'encounter_id' => null,
                'template_name' => 'general',
                'encounter_template' => json_encode([
                    [
                        'section_title' => 'Chief Complaint',
                        'section_text' => null,
                        'sorting_order' => '1',
                        'section_slug' => 'chief_complaint'
                    ],
                    [
                        'section_title' => 'HPI (History of Present Illness )',
                        'section_text' => null,
                        'sorting_order' => '2',
                        'section_slug' => 'history'
                    ],
                    [
                        'section_title' => 'Medical History',
                        'section_text' => null,
                        'sorting_order' => '3',
                        'section_slug' => 'medical-history'
                    ],
                    [
                        'section_title' => 'Surgical History',
                        'section_text' => null,
                        'sorting_order' => '4',
                        'section_slug' => 'surgical-history'
                    ],
                    [
                        'section_title' => 'Family History',
                        'section_text' => null,
                        'sorting_order' => '5',
                        'section_slug' => 'family-history'
                    ],
                    [
                        'section_title' => 'Social History',
                        'section_text' => null,
                        'sorting_order' => '6',
                        'section_slug' => 'social-history'
                    ],
                    [
                        'section_title' => 'Allergies',
                        'section_text' => null,
                        'sorting_order' => '7',
                        'section_slug' => 'allergies'
                    ],
                    [
                        'section_title' => 'Medications',
                        'section_text' => null,
                        'sorting_order' => '8',
                        'section_slug' => 'medications'
                    ],
                    [
                        'section_title' => 'Review of Systems',
                        'section_text' => null,
                        'sorting_order' => '9',
                        'section_slug' => 'review-of-systems'
                    ],
                    [
                        'section_title' => 'Vital Sign',
                        'section_text' => null,
                        'sorting_order' => '10',
                        'section_slug' => 'vital-sign'
                    ],
                    [
                        'section_title' => 'Physical Exam',
                        'section_text' => null,
                        'sorting_order' => '11',
                        'section_slug' => 'physical-exam'
                    ],
                    [
                        'section_title' => 'Assessment Notes',
                        'section_text' => null,
                        'sorting_order' => '12',
                        'section_slug' => 'assessments'
                    ],
                    [
                        'section_title' => 'Procedure',
                        'section_text' => null,
                        'sorting_order' => '13',
                        'section_slug' => 'procedure'
                    ],
                    [
                        'section_title' => 'Follow Up',
                        'section_text' => null,
                        'sorting_order' => '14',
                        'section_slug' => 'follow-up'
                    ]
                ]),
                'created_at' => '2024-07-15 09:34:10',
                'updated_at' => '2024-07-15 09:34:10',
            ],
            [
                'id' => 2,
                'provider_id' => null,
                'patient_id' => null,
                'encounter_id' => null,
                'template_name' => 'wound',
                'encounter_template' => json_encode([
                    [
                        'section_title' => '',
                        'section_slug' => 'wound_evaluation',
                        'sorting_order' => '1'
                    ],
                    [
                        'section_title' => 'Wound History',
                        'section_slug' => 'wound_history',
                        'sorting_order' => '2'
                    ],
                    [
                        'section_title' => 'Treatment Order',
                        'section_slug' => 'treatment_order',
                        'sorting_order' => '3'
                    ],
                    [
                        'section_title' => 'Assessment Notes',
                        'section_text' => null,
                        'sorting_order' => '4',
                        'section_slug' => 'assessments'
                    ],
                    [
                        'section_title' => 'Procedure',
                        'section_text' => 'The pre-procedure area was prepped in the usual aseptic manner. Local anesthesia was achieved with lidocaine spray. The chronic non-healing ulceration was debrided by mechanical methods. Devitalized tissue was removed to the level of healthy bleeding tissue which included biofilm and necrotic tissue. The instruments used included gauze scrub with cleanser. The debridement area extended down to the level of subcutaneous tissue. All surrounding periwound hyperkeratotic skin was also removed as required. Hemostasis was achieved by the usage of compression. The estimated blood loss was less than 3 ccs. The post-debridement measurements were as follows: W: 0.8 x L: 2 x D: 0.2. The debridement area was cleansed with wound cleanser then dressed with a non-adherent dressing. The patient tolerated the procedure well and there were no complications. The patient, caregiver and or patient coordinator were provided detailed post-procedure instructions. A follow-up appointment will be scheduled for approximately 1 week.',
                        'sorting_order' => '5',
                        'section_slug' => 'procedure'
                    ],
                    [
                        'section_title' => 'Pressure Injury',
                        'section_text' => 'frequent position changes, at least every 2 hours if possible. Use pressure-reducing devices such as specialized mattresses or offloading devices Encourage balanced diet with adequate protein (if not contraindicated), vitamins C and zinc to support tissue healing. Monitor for any signs of infection avoid smoking and excessive alcohol consumption emphasized importance of keeping skin clean and dry Recommend foley catheter to facilitate wound healing and keeping the patient clean and dry as urine and stool can lead to further skin breakdown. Instructed on wound dressing change',
                        'sorting_order' => '6',
                        'section_slug' => 'pressure-injury'
                    ],
                    [
                        'section_title' => 'Arterial Wounds',
                        'section_text' => '-Smoking cessation- Follow up with PCP in managing underlying conditions such as hypertension, diabetes, and hyperlipidemia to improve blood flow and overall vascular health.-Monitor for signs of infection. -keep wound clean and dry- relieve pressure on the affected area to improve blood flow.-Podiatry consult for use of special footwear,orthotics.Encourage balanced diet with adequate protein (if not contraindicated), vitamins C and zinc to support tissue healing.Monitor for any signs of infection-smoking cessation- Educated on the potential complications of arterial wounds, such as infection, gangrene, or the need for amputation and seeking prompt medical attention if complications arise.Instructed on wound dressing change-recommend,order ABI,vascular studies',
                        'sorting_order' => '7',
                        'section_slug' => 'arterial-wounds'
                    ],
                    [
                        'section_title' => 'Venous stasis wound',
                        'section_text' => '-maintain a healthy weight and diet by limiting foods high in sodium -practicing proper skin care and keep skin moist -exercise to improve blood flow-elevate extremities above the heart level whenever possible to help reduce swelling and improve circulation.-Instructed patient on the importance of compression therapy even after wound heals.Educated on the potential complications of venous stasis ulcers, such as cellulitis, skin infections, or worsening ulceration and seeking prompt medical attention if complications arise.Instructed on wound dressing change',
                        'sorting_order' => '8',
                        'section_slug' => 'venous-stasis-wound'
                    ],
                    [
                        'section_title' => 'Diabetic Ulcer',
                        'section_text' => '-Instructed on daily foot care routines, including inspecting feet for cuts, blisters, calluses, or changes in skin color or temperature and gentle washing and thorough drying of the feet- Encourage to wear diabetic-friendly shoes or custom orthotics-Podiatry consult -manage blood sugar levels within the target range through medication, diet, and exercise.-regularly monitor blood glucose levels and adherence to prescribed treatment plans.Instructed on wound dressing change-Educated on the potential complications of diabetic ulcers, such as cellulitis, osteomyelitis, or gangrene and seeking prompt medical attention if complications arise.',
                        'sorting_order' => '9',
                        'section_slug' => 'diabetic-ulcer'
                    ]
                ]),
                'created_at' => '2024-07-15 09:41:15',
                'updated_at' => '2024-07-15 09:41:15',
            ],
            [
                'id' => 3,
                'provider_id' => null,
                'patient_id' => null,
                'encounter_id' => null,
                'template_name' => 'psychiatrist',
                'encounter_template' => json_encode([
                    [
                        'section_title' => 'HPI (History of Present Illness )',
                        'section_text' => null,
                        'sorting_order' => '1',
                        'section_slug' => 'history_of_presenting_illness'
                    ],
                    [
                        'section_title' => 'Current Psych Medication',
                        'section_text' => null,
                        'sorting_order' => '2',
                        'section_slug' => 'current_psych_medication'
                    ],
                    [
                        'section_title' => 'Past Psychiatric History',
                        'section_text' => null,
                        'sorting_order' => '3',
                        'section_slug' => 'past_psychiatric_history'
                    ],
                    [
                        'section_title' => 'Prescipitating Factors',
                        'section_text' => null,
                        'sorting_order' => '4',
                        'section_slug' => 'prescipitating_factors'
                    ],
                    [
                        'section_title' => 'Assessment Notes',
                        'section_text' => null,
                        'sorting_order' => '5',
                        'section_slug' => 'assessments'
                    ],
                    [
                        'section_title' => 'Perpetuating Factors',
                        'section_text' => null,
                        'sorting_order' => '6',
                        'section_slug' => 'perpetuating_factors'
                    ],
                    [
                        'section_title' => 'Medical History',
                        'section_text' => null,
                        'sorting_order' => '7',
                        'section_slug' => 'medical_history'
                    ],
                    [
                        'section_title' => 'Family History',
                        'section_text' => null,
                        'sorting_order' => '8',
                        'section_slug' => 'family_history'
                    ],
                    [
                        'section_title' => 'Mental Status Examination',
                        'section_text' => null,
                        'sorting_order' => '9',
                        'section_slug' => 'mental_status_examination'
                    ],
                    [
                        'section_title' => 'Drug History',
                        'section_text' => null,
                        'sorting_order' => '10',
                        'section_slug' => 'drug_history'
                    ],
                    [
                        'section_title' => 'Review Of System',
                        'section_text' => 'No reported HA, fever, n/v, or diarrhea. Denied chest pain, palpitation, SOB.',
                        'sorting_order' => '11',
                        'section_slug' => 'review_of_system'
                    ],
                    [
                        'section_title' => 'Risk Assessment',
                        'section_text' => null,
                        'sorting_order' => '12',
                        'section_slug' => 'risk_assessment'
                    ],
                    [
                        'section_title' => 'Plan/Discussion',
                        'section_text' => null,
                        'sorting_order' => '13',
                        'section_slug' => 'plan_discussion'
                    ],
                    [
                        'section_title' => 'Disposition',
                        'section_text' => null,
                        'sorting_order' => '14',
                        'section_slug' => 'disposition'
                    ],
                    [
                        'section_title' => 'Procedure',
                        'section_text' => null,
                        'sorting_order' => '15',
                        'section_slug' => 'procedure'
                    ]
                ]),
                'created_at' => '2024-07-15 09:43:22',
                'updated_at' => '2024-07-15 09:43:22',
            ],
        ]);
    }
}
