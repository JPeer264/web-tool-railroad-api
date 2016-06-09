<?php

namespace App\Http\Controllers;


use Tymon\JWTAuth\JWTAuth;


class FilterHelper
{

    public function __construct(JWTAuth $auth) {
        $this->auth = $auth;
    }

    public function filterTopics($topics, $highestRole) {
        $user = $this->auth->user();

        $cachedTopics = $topics;

        foreach ($topics as $topicKey => $topic) {
            // todo delete topics not shown topics for normal users
            // todo shown for all admins < 4
            if ($user->role_id >= $highestRole) {
                $isCompanyFilterSet = false;
                $isJobFilterSet = false;
                $isInCompany = false;
                $isInJob = false;

                if (isset($topic['company'][0])) {
                    $isCompanyFilterSet = true;

                    foreach ($topic['company'] as $company) {
                        if ($company->id == $user->company_id) {
                            $isInCompany = true;
                        }
                    }
                }

                if (isset($topic['job'][0])) {
                    $isJobFilterSet = true;

                    foreach ($topic['job'] as $job) {
                        if ($job->id == $user->job_id) {
                            $isInJob = true;
                        }
                    }
                }

                // if both filter are set
                if ($isCompanyFilterSet && $isJobFilterSet) {
                    if (!$isInJob || !$isInCompany) {
                        unset($cachedTopics[$topicKey]);
                    }
                }

                // if just company filter isset
                if ($isCompanyFilterSet && !$isJobFilterSet) {
                    if (!$isInCompany) {
                        unset($cachedTopics[$topicKey]);
                    }
                }

                // if just job filter isset
                if (!$isCompanyFilterSet && $isJobFilterSet) {
                    if (!$isInJob) {
                        unset($cachedTopics[$topicKey]);
                    }
                }
            }
        }

        return $cachedTopics;
    }
}
