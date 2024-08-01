<?php

namespace Atlassian\JiraRest\Requests\Issue;

use Atlassian\JiraRest\Requests\AbstractRequest;
use Atlassian\JiraRest\Requests\Issue\Traits;

/**
 * Class IssueRequest
 *
 * @package Atlassian\JiraRest\Requests\Issue
 */
class IssueCommentRequest extends AbstractRequest
{
    use Traits\PropertiesRequests;
    use Traits\CommentRequests;
    use Traits\WorklogsRequests;

    /**
     * Creates an issue or a sub-task from a JSON representation.
     *
     * @see https://developer.atlassian.com/cloud/jira/platform/rest/v3/#api-rest-api-3-issue-post
     *
     * @param  array|\Illuminate\Contracts\Support\Arrayable  $parameters
     *
     * @return \GuzzleHttp\Psr7\Response
     * @throws \Atlassian\JiraRest\Exceptions\JiraClientException
     * @throws \Atlassian\JiraRest\Exceptions\JiraNotFoundException
     * @throws \Atlassian\JiraRest\Exceptions\JiraUnauthorizedException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create($issueIdOrKey, $parameters = [])
    {
        return $this->execute('post', 'issue/'.$issueIdOrKey.'/comment', $parameters);
    }

    /**
     * @see https://developer.atlassian.com/cloud/jira/platform/rest/v3/#api-rest-api-3-issue-bulk-post
     * @throws \Exception
     */
    public function bulkCreate()
    {
        // TODO: implement
        throw new \Exception('Not yet implemented');
    }

    /**
     * @see https://developer.atlassian.com/cloud/jira/platform/rest/v3/#api-rest-api-3-issue-createmeta-get
     * @throws \Exception
     */
    public function getCreateMetadata()
    {
        // TODO: implement
        throw new \Exception('Not yet implemented');
    }

    /**
     * Returns a full representation of the issue comment for the given issue key.
     *
     * @see https://developer.atlassian.com/cloud/jira/platform/rest/v3/#api-rest-api-3-issue-issueIdOrKey-get
     *
     * @param  string|int  $issueIdOrKey
     * @param  array|\Illuminate\Contracts\Support\Arrayable  $parameters
     *
     * @return \GuzzleHttp\Psr7\Response
     * @throws \Atlassian\JiraRest\Exceptions\JiraClientException
     * @throws \Atlassian\JiraRest\Exceptions\JiraNotFoundException
     * @throws \Atlassian\JiraRest\Exceptions\JiraUnauthorizedException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get($issueIdOrKey, $parameters = [])
    {
        return $this->execute('get', "issue/{$issueIdOrKey}/comment", $parameters);
    }

    /**
     * Edits the issue from a JSON representation.
     *
     * @see https://developer.atlassian.com/cloud/jira/platform/rest/v3/#api-rest-api-3-issue-issueIdOrKey-put
     *
     * @param  string|int  $issueIdOrKey
     * @param  array|\Illuminate\Contracts\Support\Arrayable  $parameters
     *
     * @return \GuzzleHttp\Psr7\Response
     * @throws \Atlassian\JiraRest\Exceptions\JiraClientException
     * @throws \Atlassian\JiraRest\Exceptions\JiraNotFoundException
     * @throws \Atlassian\JiraRest\Exceptions\JiraUnauthorizedException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TypeError
     */
    public function edit($issueIdOrKey, $commentId,  $parameters = [])
    {
        return $this->execute('put', "issue/{$issueIdOrKey}/comment/".$commentId, $parameters);
    }

    /**
     * Deletes an individual issue comment.
     *
     * @see https://developer.atlassian.com/cloud/jira/platform/rest/v3/#api-rest-api-3-issue-issueIdOrKey-delete
     *
     * @param  string|int  $issueIdOrKey  ID or key of the issue to be deleted.
     * @param  bool  $deleteSubtasks  A true or false value indicating if sub-tasks should be deleted.
     *
     * @return \GuzzleHttp\Psr7\Response
     * @throws \Atlassian\JiraRest\Exceptions\JiraClientException
     * @throws \Atlassian\JiraRest\Exceptions\JiraNotFoundException
     * @throws \Atlassian\JiraRest\Exceptions\JiraUnauthorizedException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete($issueIdOrKey,$commentId, $deleteSubtasks = false)
    {
        return $this->execute('delete', "issue/{$issueIdOrKey}/comment/".$commentId, [], true);
    }




    /**
     * Returns a paginated list of all updates of an issue, sorted by date, starting from the oldest.
     *
     * @see https://developer.atlassian.com/cloud/jira/platform/rest/v3/#api-rest-api-3-issue-issueIdOrKey-changelog-get
     *
     * @param  string|int  $issueIdOrKey
     *
     * @throws \Exception
     */
    public function getChangeLogs($issueIdOrKey)
    {
        // TODO: implement
        throw new \Exception('Not yet implemented');
    }


}
