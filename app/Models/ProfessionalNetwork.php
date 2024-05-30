<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionalNetwork extends Model
{
    use HasFactory;
    protected $table = 'professional_network';
    protected $fillable = [
        'following_user_id',
        'PermanentAddress',
        'Position',
        'Skills',
        'Portfolio',
        'LinkedInURL',
        'SkillsToExplore',
        'ModeOfWork',
        'Purpose',
        'InterestsHobbies',
        'Type',
        'ResumeFile',
        'delete_status',
    ];

    public function followingUser()
    {
        return $this->belongsTo(User::class, 'following_user_id');
    }
}
