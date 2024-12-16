<?php

namespace OzanKurt\Blog\Models\Traits;

use Illuminate\Support\HtmlString;
use OzanKurt\Blog\Exceptions\InvalidVideoTypeException;

/**
 * @mixin \Eloquent
 */
trait HasVideo
{
    public function getVideoId(): string
    {
        switch ($this->video_type_id) {
            case self::VIDEO_TYPE_DAILYMOTION:
                return get_daily_motion_id($this->media);
                break;
            case self::VIDEO_TYPE_VIMEO:
                return get_vimeo_id($this->media);
                break;
            case self::VIDEO_TYPE_YOUTUBE:
                return get_youtube_id($this->media);
                break;
            default:
                throw new InvalidVideoTypeException;
        }
    }

    public function getVideoThumbnail(): string
    {
        $qualities = config('blog.video_thumbnail_qualities');

        switch ($this->video_type_id) {
            case self::VIDEO_TYPE_DAILYMOTION:
                return 'http://www.dailymotion.com/thumbnail/video/' . $this->getVideoId();
                break;
            case self::VIDEO_TYPE_VIMEO:
                $result = file_get_contents('http://vimeo.com/api/v2/video/' . $this->getVideoId() . '.php');

                $hash = unserialize($result);

                return $hash[0][$qualities['vimeo']];
                break;
            case self::VIDEO_TYPE_YOUTUBE:
                return 'http://img.youtube.com/vi/' . $this->getVideoId() . '/' . $qualities['youtube'] . '.jpg';
                break;
            default:
                throw new InvalidVideoTypeException;
        }
    }

    public function getVideoUrl(): string
    {
        switch ($this->video_type_id) {
            case self::VIDEO_TYPE_DAILYMOTION:
                return 'http://www.dailymotion.com/embed/video/' . $this->getVideoId();
                break;
            case self::VIDEO_TYPE_VIMEO:
                return 'http://player.vimeo.com/video/' . $this->getVideoId();
                break;
            case self::VIDEO_TYPE_YOUTUBE:
                return 'http://www.youtube.com/embed/' . $this->getVideoId();
                break;
            default:
                throw new InvalidVideoTypeException;
        }
    }

    public function getVideoEmbed(): HtmlString
    {
        $html = "<style>.embed-container { position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width: 100%; } .embed-container iframe, .embed-container object, .embed-container embed { position: absolute; top: 0; left: 0; width: 100%; height: 100%; } </style>";

        $html .= "<div class='embed-container'><iframe src=" . $this->getVideoUrl() . " frameborder='0' awebkitAllowFullScreen mozallowfullscreen llowfullscreen></iframe></div>";

        return new HtmlString($html);
    }
}
