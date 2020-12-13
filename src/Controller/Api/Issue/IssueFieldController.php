<?php

namespace App\Controller\Api\Issue;

use App\Controller\Api\ApiController;
use App\Module\Issue\Api\ApiInterface;
use App\Module\Issue\Api\Exception\ApiException;
use App\Module\Issue\Api\Input\AddIssueFieldInput;
use App\Module\Issue\Api\Input\EditIssueFieldInput;
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

            return $this->json(['error' => 'unknown_error']);
        }
    }

    public function editField(Request $request, ApiInterface $api): Response
    {
        try
        {
            $api->editIssueField(new EditIssueFieldInput(
                $request->get('issue_field_id'),
                $request->get('name'),
                $request->get('type')
            ));

            return new Response();
        }
        catch (ApiException $exception)
        {
            if ($exception->getType() === ApiException::ISSUE_FIELD_BY_NOT_FOUND)
            {
                return $this->json(['error' => 'issue_field_by_id_not_found']);
            }

            if ($exception->getType() === ApiException::ISSUE_FIELD_NAME_BUSY)
            {
                return $this->json(['error' => 'issue_field_name_busy']);
            }

            return $this->json(['error' => 'unknown_error']);
        }
    }
}