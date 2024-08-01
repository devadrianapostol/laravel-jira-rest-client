<?php

namespace Atlassian\JiraRest\Requests\Attachment;

use Atlassian\JiraRest\Exceptions\JiraClientException;
use Atlassian\JiraRest\Exceptions\JiraNotFoundException;
use Atlassian\JiraRest\Exceptions\JiraUnauthorizedException;
use Atlassian\JiraRest\Requests\AbstractRequest;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;
class AttachmentRequest extends AbstractRequest
{
    /**
     * Returns a  representation of the attachment for the given attachment key.
     *
     * @see https://developer.atlassian.com/cloud/jira/platform/rest/v3/api-group-issue-attachments
     *
     * @param  string|int  $attachmentId
     * @param  array|\Illuminate\Contracts\Support\Arrayable  $parameters
     *
     * @return \GuzzleHttp\Psr7\Response
     * @throws \Atlassian\JiraRest\Exceptions\JiraClientException
     * @throws \Atlassian\JiraRest\Exceptions\JiraNotFoundException
     * @throws \Atlassian\JiraRest\Exceptions\JiraUnauthorizedException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function content($attachmentId, $parameters = [])
    {
        return $this->execute('get', "attachment/content/{$attachmentId}", $parameters ) ;
    }
    public function get($attachmentId, $parameters = [])
    {
        return $this->execute('get', "attachment/{$attachmentId}", $parameters);
    }



    public function create($issueIdOrKey, $parameters = [], $asQueryParameters=false){
        $method = 'post';
        $resource = "issue/$issueIdOrKey/attachments";
        $options = [
            'base_uri' => config('atlassian.jira.host'),
            'headers'  => [
                'Accept'       => 'application/json',
                //'Content-Type' => 'application/json',
                'Content-Type'          => 'multipart/form-data',
                'X-Atlassian-Token' => 'no-check'
            ] ,
        ];
        if(isset($parameters['file'])){
            $options['multipart'] = [
                [
                    'name' => 'file',
                    'contents' => file_get_contents($parameters['file']['path']),
                    'filename' => $parameters['file']['name'],
                ]
            ];
        }

        app(\Illuminate\Pipeline\Pipeline::class)
            ->send($options)
            ->through($this->middleware)
            ->then(function ($options) use($method, $parameters, $asQueryParameters,$resource) {
                $this->client = new Client($options);
                $client = $this->client;
                try {
                    if ($this->async) {
                        return $client->requestAsync($method, $this->getRequestUrl($resource), $parameters);
                    }

                    return $client->request($method, $this->getRequestUrl($resource), $parameters);
                } catch (RequestException $exception) {
                    $message = $this->getJiraException($exception);

                    switch ($exception->getCode()) {
                        case 401:
                            $message = __('You are not authenticated. Authentication required to perform this operation.');
                            throw new JiraUnauthorizedException($message, 401, $exception);
                        case 404:
                            throw new JiraNotFoundException($message, 404, $exception);
                        default:
                            throw new JiraClientException($message, $exception->getCode(), $exception);
                    }
                }
            });
        //$this->client = new Client($options);


    }

}