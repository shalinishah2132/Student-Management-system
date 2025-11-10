<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_name',
        'student_email',
        'student_phone',
        'total_marks',
        'rank',
    ];

    protected $casts = [
        'total_marks' => 'integer',
    ];

    // Accessor to get rank with proper formatting
    public function getRankDisplayAttribute()
    {
        return $this->rank ?: 'Not Ranked';
    }

    // Scope to get students by rank
    public function scopeByRank($query, $rank)
    {
        return $query->where('rank', $rank);
    }

    // Scope to get top performers
    public function scopeTopPerformers($query, $limit = 10)
    {
        return $query->orderBy('total_marks', 'desc')->limit($limit);
    }

    // Method to calculate and update rank based on total marks
    public static function updateRanks()
    {
        $students = self::orderBy('total_marks', 'desc')->get();
        
        foreach ($students as $index => $student) {
            $rank = match(true) {
                $student->total_marks >= 400 => 'First Class',
                $student->total_marks >= 300 => 'Second Class',
                $student->total_marks >= 200 => 'Third Class',
                default => 'Fail'
            };
            
            $student->update(['rank' => $rank]);
        }
    }

    // Relationships
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'enrollments');
    }
}
