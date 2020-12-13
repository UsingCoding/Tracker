<?php

namespace App\Controller\Api\Issue;

use App\Controller\Api\ApiController;
use App\Module\Issue\Api\ApiInterface;
use App\Module\Issue\Api\Exception\ApiException;
use App\Module\Issue\Api\Input\AddIssueFieldInput;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IssueFieldController extends ApiController
{
    public function addField(Request $request, ApiInterface $api): Response
    {
        try
        {
            $issueFieldId = $api->addIssueField(new AddIssueFieldInput(
                $request->get('name'),
                $request->get('type'),
                $request->get('project_id')
            ));

            return $this->json(['issue_field_id' => $issueFieldId]);
        }
        catch (ApiException $e)
        {
            if ($e->getType() === ApiException::ISSUE_FIELD_NAME_BUSY)
            {
                return $this->json(['error'=> 'issue_filed_name_busy']);
            }

            return $this->json(['error' => (string) $e]);
        }
    }
}