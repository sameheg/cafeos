<?php

namespace Modules\Membership\Enums;

enum MemberRole: string
{
    case SAAS_STAFF = 'saas_staff';
    case OWNER = 'owner';
    case EMPLOYEE = 'employee';
    case SUPPLIER = 'supplier';
    case JOB_SEEKER = 'job_seeker';
    case ADVERTISER = 'advertiser';
}
