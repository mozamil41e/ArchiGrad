<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;

use Illuminate\Validation\ValidationException;

class LoginApp extends Component
{
    #[Validate('required|email', message: [
        'required' => 'البريد الإلكتروني مطلوب',
        'email' => 'البريد الإلكتروني غير صالح',
    ])]
    public string $email = '';

    #[Validate('required|min:6', message: [
        'required' => 'كلمة المرور مطلوبة',
        'min' => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل',
    ])]
    public string $password = '';

    public bool $rememberMe = false;

    public array $existingProjects = [
        "نظام إدارة مشاريع التخرج",
        "تطبيق مكتبي لإدارة الطلاب",
        "نظام متابعة مشاريع بصات"
    ];

    public string $newTitle = "نظام ادارة تزاكر باصات";

    /**
     * تحقق من تشابه عنوان المشروع مع المشاريع السابقة
     *
     * @param string $newTitle العنوان الجديد
     * @param array $existingTitles مصفوفة عناوين المشاريع السابقة
     * @param int $threshold نسبة التشابه المئوية لمنع التكرار (مثلاً 70)
     * @return array يحتوي على المشاريع المشابهة مع نسبة التشابه
     */
    function checkProjectSimilarity(string $newTitle, array $existingTitles, int $threshold = 70): array
    {
        $similarProjects = [];

        foreach ($existingTitles as $title) {
            // استخدام similar_text لحساب نسبة التشابه
            similar_text($newTitle, $title, $percent);

            // إذا كانت النسبة أكبر من الحد المسموح
            if ($percent >= $threshold) {
                $similarProjects[] = [
                    'existing_title' => $title,
                    'similarity' => round($percent, 2) // تقريب النسبة
                ];
            }
        }

        return $similarProjects; // مصفوفة المشاريع المشابهة
    }




    public function submitForm()
    {
        // $similar = $this->checkProjectSimilarity($this->newTitle, $this->existingProjects);
        // return dd($similar);
        // if (!empty($similar)) {
        //     echo "هذا العنوان مشابه للعناوين التالية:\n";
        //     foreach ($similar as $item) {
        //         echo "- {$item['existing_title']} (تشابه: {$item['similarity']}%)\n";
        //     }
        // } else {
        //     echo "العنوان جديد ويمكن استخدامه!";
        // }

        $this->validate();

        if (Auth::attempt(
            ['email' => $this->email, 'password' => $this->password],
            $this->rememberMe
        )) {
            session()->regenerate();
            return redirect()->intended('/');
        }

        throw ValidationException::withMessages([
            'email' => 'بيانات الدخول غير صحيحة',
        ]);
    }

    public function render()
    {
        return view('livewire.auth.login-app');
    }
}
