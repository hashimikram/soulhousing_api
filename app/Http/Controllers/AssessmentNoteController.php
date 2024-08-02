<?php

namespace App\Http\Controllers;

use App\Models\EncounterNoteSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssessmentNoteController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'assessment_input' => 'required',
        ]);
        try {
            $get_record = DB::table('problem_quotes')->where('code', $request->code)->first();
            if (isset($get_record)) {
                DB::table('problem_quotes')
                    ->where('code', $request->code)
                    ->update(['assessment_notes' => $request->assessment_input]);
                return response()->json(['status' => 'success', 'message' => 'Assessment Note Saved Successfully']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Record Not Found']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Invalid Request']);
        }
    }

    public function destroy($id, $value_id)
    {
        $encounter_note = EncounterNoteSection::find($id);
        if ($encounter_note) {
            $assessment_note = json_decode($encounter_note->assessment_note, true);

            if ($assessment_note) {
                $filtered_note = array_filter($assessment_note, function ($data) use ($value_id) {
                    return $data['value_id'] != $value_id;
                });

                $encounter_note->assessment_note = json_encode(array_values($filtered_note));
                $encounter_note->save();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Done'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'false',
                    'message' => 'Not Found'
                ], 404);
            }

        }
        return response()->json([
            'status' => 'false',
            'message' => 'Not Found'
        ], 404);
    }

}
