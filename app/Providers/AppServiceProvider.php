<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Test;
use App\Question;
use App\AnswerVariant;
use App\ScoreScale;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Test::deleted(function (Test $test) {
            $test->questions->each(function (Question $question) {
                $question->delete();
            });

            $test->scoreScales->each(function (ScoreScale $scoreScale) {
                $scoreScale->delete();
            });
        });

        Question::deleted(function ($question) {
            if ($question->question_type_id === 3)
            {
                $question->answerFree->delete();
            }
            else
            {
                $question->answerVariants->each(function (AnswerVariant $answerVariant) {
                    $answerVariant->delete();
                });
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
