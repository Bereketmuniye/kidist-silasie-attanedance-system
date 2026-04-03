<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\StudentRegistrationConfirmation;

class StudentRegistrationController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.student-register');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'full_name' => ['nullable', 'string', 'max:255'],
            'baptismal_name' => ['nullable', 'string', 'max:255'],
            'partner_full_name' => ['nullable', 'string', 'max:255'],
            'partner_baptismal_name' => ['nullable', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s()]+$/'],
            'address' => ['required', 'string', 'max:500'],
            'common_confessor_father' => ['nullable', 'string', 'max:255'],
            'agreement' => ['required', 'accepted'],
        ], [
            'phone_number.required' => 'ስልክ ቁጥር መሙላት ግዴታ ነው።',
            'phone_number.regex' => 'እባክዎ ትክክለኛ ስልክ ቁጥር ያስገቡ።',
            'address.required' => 'አድራሻ መሙላት ግዴታ ነው።',
            'agreement.required' => 'ከመመዝገብዎ በፊት የትምህርቱን ዓላማ መረዳትዎን እና መስማማትዎን መግለጽ ግዴታ ነው።',
            'agreement.accepted' => 'ከመመዝገብዎ በፊት የትምህርቱን ዓላማ መረዳትዎን እና መስማማትዎን መግለጽ ግዴታ ነው።',
        ])->after(function ($validator) use ($data) {
            // Require at least one person's name
            if (empty($data['full_name']) && empty($data['partner_full_name'])) {
                $validator->errors()->add('full_name', 'እባክዎ ወንዱ ወይም ሴት ማንኛውን ስም መሙላት ግዴታ ነው።');
            }
        });
    }

    protected function create(array $data)
    {
        // Use male name if provided, otherwise use partner name
        $fullName = $data['full_name'] ?? $data['partner_full_name'];
        
        return Student::create([
            'full_name' => $fullName,
            'baptismal_name' => $data['baptismal_name'] ?? null,
            'phone_number' => $data['phone_number'],
            'address' => $data['address'],
            'common_confessor_father' => $data['common_confessor_father'] ?? null,
            'is_active' => true,
        ]);
    }

    public function register(Request $request)
    {
        $validator = $this->validator($request->all());
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $student = $this->create($request->all());
            
            // Send confirmation email if email is available in the future
            // Mail::to($student->email)->send(new StudentRegistrationConfirmation($student));
            
            return redirect()->route('student.register.success')
                ->with('success', 'መመዝገብዎ በተሳካ ሁኔታ ተጠናቋል! በቅድሚያ ትምህርት ላይ መሳተፅዎን እናመሰግናለን።')
                ->with('student_name', $student->full_name);
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'በመመዝገብዎ ላይ ስህተት ተፈጥሯል። እባክዎ እንደገና ይሞክሩ።')
                ->withInput();
        }
    }

    public function registrationSuccess()
    {
        return view('auth.student-register-success');
    }
}
