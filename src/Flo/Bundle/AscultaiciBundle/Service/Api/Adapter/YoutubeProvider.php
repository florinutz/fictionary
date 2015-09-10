<?php
namespace Flo\Bundle\AscultaiciBundle\Service\Api\Adapter;

class YoutubeProvider implements ApiProviderInterface
{
    /**
     * @var \Google_Auth_AssertionCredentials
     */
    protected $credentials;

    /**
     * @param string $clientEmail
     * @param string $privateKeyPath
     * @param array $scopes
     */
    public function __construct($clientEmail, $privateKeyPath, array $scopes)
    {
        $this->credentials = $this->buildCredentialsObject($clientEmail, $privateKeyPath, $scopes);
    }


    /**
     * @param string $url
     *
     * @return mixed
     */
    public function oembed($url)
    {
    }

    /**
     * @param $clientEmail
     * @param $privateKeyPath
     * @param array $scopes
     *
     * @return \Google_Auth_AssertionCredentials
     */
    protected function buildCredentialsObject($clientEmail, $privateKeyPath, array $scopes)
    {
        if (!$key = file_get_contents($privateKeyPath)) {
            throw new \InvalidArgumentException('Could not open the google key file');
        }

        return new \Google_Auth_AssertionCredentials($clientEmail, $scopes, $key);
    }
}
