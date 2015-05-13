<?php

namespace Bolt\Extension\MalangPHP\FacebookEvent;

use Bolt\BaseExtension;
use Facebook\FacebookRequest;
use Facebook\FacebookRequestException;
use Facebook\FacebookSession;

/**
 * Class Extension
 * @package Bolt\Extension\MalangPHP\FacebookEvent
 */
class Extension extends BaseExtension
{
    /**
     * @var FacebookSession
     */
    protected $facebook_session;

    /**
     * initialize
     */
    public function initialize()
    {
        FacebookSession::setDefaultApplication($this->config["app_id"], $this->config["app_secret"]);

        $this->facebook_session = new FacebookSession($this->config["access_token"]);

        $this->addTwigFunction("facebook_event", "facebookEvent");
        $this->addTwigFunction("facebook_event_attendee", "facebookEventAttendee");
        $this->addTwigFunction("facebook_event_feed", "facebookEventFeed");
        $this->addTwigFunction("facebook_event_photos", "facebookEventPhotos");
    }

    /**
     * @return string
     */
    public function getName()
    {
        return "FacebookEvent";
    }

    /**
     * @param int $event_id
     * @return array|void
     * @throws FacebookRequestException
     */
    public function facebookEvent($event_id)
    {
        try {
            $event = (new FacebookRequest(
                $this->facebook_session, "GET", "/{$event_id}"
            ))->execute()->getGraphObject();

            $event = $event->asArray();

            $event_attendee = (new FacebookRequest(
                $this->facebook_session, "GET", "/{$event_id}/?fields=attending_count,maybe_count,place"
            ))->execute()->getGraphObject();

            return array_merge($event, $event_attendee->asArray());
        } catch (FacebookRequestException $e) {
            $this->app['logger.change']->error($e->getMessage());
            return;
        }
    }

    /**
     * @param int $event_id
     * @param int $limit
     * @return array
     * @throws FacebookRequestException
     */
    public function facebookEventAttendee($event_id, $limit = 50)
    {
        try {
            $attending = (new FacebookRequest(
                $this->facebook_session, "GET", "/{$event_id}/attending?limit={$limit}"
            ))->execute()->getGraphObject();

            $attendee = $attending->getProperty("data");
            return $attendee->asArray();
        } catch (FacebookRequestException $e) {
            $this->app['logger.change']->error($e->getMessage());
        }
    }

    /**
     * @param int $event_id
     * @param int $limit
     * @return array
     * @throws FacebookRequestException
     */
    public function facebookEventPhotos($event_id, $limit = 10)
    {
        try {
            $photos = (new FacebookRequest(
                $this->facebook_session, "GET", "/{$event_id}/photos?limit={$limit}"
            ))->execute()->getGraphObject();

            $photos = $photos->getProperty("data");
            return $photos->asArray();
        } catch (FacebookRequestException $e) {
            $this->app['logger.change']->error($e->getMessage());
        }
    }

    /**
     * @param int $event_id
     * @param int $limit
     * @return array
     * @throws FacebookRequestException
     */
    public function facebookEventFeed($event_id, $limit = 10)
    {
        try {
            $feed = (new FacebookRequest(
                $this->facebook_session, "GET", "/{$event_id}/feed?limit={$limit}"
            ))->execute()->getGraphObject();

            $feed = $feed->getProperty("data");
            return $feed->asArray();
        } catch (FacebookRequestException $e) {
            $this->app['logger.change']->error($e->getMessage());
        }
    }
}
