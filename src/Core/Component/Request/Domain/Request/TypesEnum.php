<?php

namespace Accel\App\Core\Component\Request\Domain\Request;

enum TypesEnum: string
{
    case RegisterProject = 'register_project';

    case RegisterInvestor = 'register_investor';

    case ChangeInvestorRequisites = 'change_investor_requisites';

    case ChangeProjectBusinessData = 'change_project_business_data';
}
