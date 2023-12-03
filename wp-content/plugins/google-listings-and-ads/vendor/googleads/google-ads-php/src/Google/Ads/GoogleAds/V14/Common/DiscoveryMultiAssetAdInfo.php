<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/ads/googleads/v14/common/ad_type_infos.proto

namespace Google\Ads\GoogleAds\V14\Common;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * A discovery multi asset ad.
 *
 * Generated from protobuf message <code>google.ads.googleads.v14.common.DiscoveryMultiAssetAdInfo</code>
 */
class DiscoveryMultiAssetAdInfo extends \Google\Protobuf\Internal\Message
{
    /**
     * Marketing image assets to be used in the ad. Valid image types are GIF,
     * JPEG, and PNG. The minimum size is 600x314 and the aspect ratio must
     * be 1.91:1 (+-1%). Required if square_marketing_images is
     * not present. Combined with `square_marketing_images` and
     * `portrait_marketing_images` the maximum is 20.
     *
     * Generated from protobuf field <code>repeated .google.ads.googleads.v14.common.AdImageAsset marketing_images = 1;</code>
     */
    private $marketing_images;
    /**
     * Square marketing image assets to be used in the ad. Valid image types are
     * GIF, JPEG, and PNG. The minimum size is 300x300 and the aspect ratio must
     * be 1:1 (+-1%). Required if marketing_images is not present.  Combined with
     * `marketing_images` and `portrait_marketing_images` the maximum is 20.
     *
     * Generated from protobuf field <code>repeated .google.ads.googleads.v14.common.AdImageAsset square_marketing_images = 2;</code>
     */
    private $square_marketing_images;
    /**
     * Portrait marketing image assets to be used in the ad. Valid image types are
     * GIF, JPEG, and PNG. The minimum size is 480x600 and the aspect ratio must
     * be 4:5 (+-1%).  Combined with `marketing_images` and
     * `square_marketing_images` the maximum is 20.
     *
     * Generated from protobuf field <code>repeated .google.ads.googleads.v14.common.AdImageAsset portrait_marketing_images = 3;</code>
     */
    private $portrait_marketing_images;
    /**
     * Logo image assets to be used in the ad. Valid image types are GIF,
     * JPEG, and PNG. The minimum size is 128x128 and the aspect ratio must be
     * 1:1(+-1%). At least 1 and max 5 logo images can be specified.
     *
     * Generated from protobuf field <code>repeated .google.ads.googleads.v14.common.AdImageAsset logo_images = 4;</code>
     */
    private $logo_images;
    /**
     * Headline text asset of the ad. Maximum display width is 30. At least 1 and
     * max 5 headlines can be specified.
     *
     * Generated from protobuf field <code>repeated .google.ads.googleads.v14.common.AdTextAsset headlines = 5;</code>
     */
    private $headlines;
    /**
     * The descriptive text of the ad. Maximum display width is 90. At least 1 and
     * max 5 descriptions can be specified.
     *
     * Generated from protobuf field <code>repeated .google.ads.googleads.v14.common.AdTextAsset descriptions = 6;</code>
     */
    private $descriptions;
    /**
     * The Advertiser/brand name. Maximum display width is 25. Required.
     *
     * Generated from protobuf field <code>optional string business_name = 7;</code>
     */
    protected $business_name = null;
    /**
     * Call to action text.
     *
     * Generated from protobuf field <code>optional string call_to_action_text = 8;</code>
     */
    protected $call_to_action_text = null;
    /**
     * Boolean option that indicates if this ad must be served with lead form.
     *
     * Generated from protobuf field <code>optional bool lead_form_only = 9;</code>
     */
    protected $lead_form_only = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array<\Google\Ads\GoogleAds\V14\Common\AdImageAsset>|\Google\Protobuf\Internal\RepeatedField $marketing_images
     *           Marketing image assets to be used in the ad. Valid image types are GIF,
     *           JPEG, and PNG. The minimum size is 600x314 and the aspect ratio must
     *           be 1.91:1 (+-1%). Required if square_marketing_images is
     *           not present. Combined with `square_marketing_images` and
     *           `portrait_marketing_images` the maximum is 20.
     *     @type array<\Google\Ads\GoogleAds\V14\Common\AdImageAsset>|\Google\Protobuf\Internal\RepeatedField $square_marketing_images
     *           Square marketing image assets to be used in the ad. Valid image types are
     *           GIF, JPEG, and PNG. The minimum size is 300x300 and the aspect ratio must
     *           be 1:1 (+-1%). Required if marketing_images is not present.  Combined with
     *           `marketing_images` and `portrait_marketing_images` the maximum is 20.
     *     @type array<\Google\Ads\GoogleAds\V14\Common\AdImageAsset>|\Google\Protobuf\Internal\RepeatedField $portrait_marketing_images
     *           Portrait marketing image assets to be used in the ad. Valid image types are
     *           GIF, JPEG, and PNG. The minimum size is 480x600 and the aspect ratio must
     *           be 4:5 (+-1%).  Combined with `marketing_images` and
     *           `square_marketing_images` the maximum is 20.
     *     @type array<\Google\Ads\GoogleAds\V14\Common\AdImageAsset>|\Google\Protobuf\Internal\RepeatedField $logo_images
     *           Logo image assets to be used in the ad. Valid image types are GIF,
     *           JPEG, and PNG. The minimum size is 128x128 and the aspect ratio must be
     *           1:1(+-1%). At least 1 and max 5 logo images can be specified.
     *     @type array<\Google\Ads\GoogleAds\V14\Common\AdTextAsset>|\Google\Protobuf\Internal\RepeatedField $headlines
     *           Headline text asset of the ad. Maximum display width is 30. At least 1 and
     *           max 5 headlines can be specified.
     *     @type array<\Google\Ads\GoogleAds\V14\Common\AdTextAsset>|\Google\Protobuf\Internal\RepeatedField $descriptions
     *           The descriptive text of the ad. Maximum display width is 90. At least 1 and
     *           max 5 descriptions can be specified.
     *     @type string $business_name
     *           The Advertiser/brand name. Maximum display width is 25. Required.
     *     @type string $call_to_action_text
     *           Call to action text.
     *     @type bool $lead_form_only
     *           Boolean option that indicates if this ad must be served with lead form.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Ads\GoogleAds\V14\Common\AdTypeInfos::initOnce();
        parent::__construct($data);
    }

    /**
     * Marketing image assets to be used in the ad. Valid image types are GIF,
     * JPEG, and PNG. The minimum size is 600x314 and the aspect ratio must
     * be 1.91:1 (+-1%). Required if square_marketing_images is
     * not present. Combined with `square_marketing_images` and
     * `portrait_marketing_images` the maximum is 20.
     *
     * Generated from protobuf field <code>repeated .google.ads.googleads.v14.common.AdImageAsset marketing_images = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getMarketingImages()
    {
        return $this->marketing_images;
    }

    /**
     * Marketing image assets to be used in the ad. Valid image types are GIF,
     * JPEG, and PNG. The minimum size is 600x314 and the aspect ratio must
     * be 1.91:1 (+-1%). Required if square_marketing_images is
     * not present. Combined with `square_marketing_images` and
     * `portrait_marketing_images` the maximum is 20.
     *
     * Generated from protobuf field <code>repeated .google.ads.googleads.v14.common.AdImageAsset marketing_images = 1;</code>
     * @param array<\Google\Ads\GoogleAds\V14\Common\AdImageAsset>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setMarketingImages($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Ads\GoogleAds\V14\Common\AdImageAsset::class);
        $this->marketing_images = $arr;

        return $this;
    }

    /**
     * Square marketing image assets to be used in the ad. Valid image types are
     * GIF, JPEG, and PNG. The minimum size is 300x300 and the aspect ratio must
     * be 1:1 (+-1%). Required if marketing_images is not present.  Combined with
     * `marketing_images` and `portrait_marketing_images` the maximum is 20.
     *
     * Generated from protobuf field <code>repeated .google.ads.googleads.v14.common.AdImageAsset square_marketing_images = 2;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getSquareMarketingImages()
    {
        return $this->square_marketing_images;
    }

    /**
     * Square marketing image assets to be used in the ad. Valid image types are
     * GIF, JPEG, and PNG. The minimum size is 300x300 and the aspect ratio must
     * be 1:1 (+-1%). Required if marketing_images is not present.  Combined with
     * `marketing_images` and `portrait_marketing_images` the maximum is 20.
     *
     * Generated from protobuf field <code>repeated .google.ads.googleads.v14.common.AdImageAsset square_marketing_images = 2;</code>
     * @param array<\Google\Ads\GoogleAds\V14\Common\AdImageAsset>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setSquareMarketingImages($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Ads\GoogleAds\V14\Common\AdImageAsset::class);
        $this->square_marketing_images = $arr;

        return $this;
    }

    /**
     * Portrait marketing image assets to be used in the ad. Valid image types are
     * GIF, JPEG, and PNG. The minimum size is 480x600 and the aspect ratio must
     * be 4:5 (+-1%).  Combined with `marketing_images` and
     * `square_marketing_images` the maximum is 20.
     *
     * Generated from protobuf field <code>repeated .google.ads.googleads.v14.common.AdImageAsset portrait_marketing_images = 3;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getPortraitMarketingImages()
    {
        return $this->portrait_marketing_images;
    }

    /**
     * Portrait marketing image assets to be used in the ad. Valid image types are
     * GIF, JPEG, and PNG. The minimum size is 480x600 and the aspect ratio must
     * be 4:5 (+-1%).  Combined with `marketing_images` and
     * `square_marketing_images` the maximum is 20.
     *
     * Generated from protobuf field <code>repeated .google.ads.googleads.v14.common.AdImageAsset portrait_marketing_images = 3;</code>
     * @param array<\Google\Ads\GoogleAds\V14\Common\AdImageAsset>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setPortraitMarketingImages($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Ads\GoogleAds\V14\Common\AdImageAsset::class);
        $this->portrait_marketing_images = $arr;

        return $this;
    }

    /**
     * Logo image assets to be used in the ad. Valid image types are GIF,
     * JPEG, and PNG. The minimum size is 128x128 and the aspect ratio must be
     * 1:1(+-1%). At least 1 and max 5 logo images can be specified.
     *
     * Generated from protobuf field <code>repeated .google.ads.googleads.v14.common.AdImageAsset logo_images = 4;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getLogoImages()
    {
        return $this->logo_images;
    }

    /**
     * Logo image assets to be used in the ad. Valid image types are GIF,
     * JPEG, and PNG. The minimum size is 128x128 and the aspect ratio must be
     * 1:1(+-1%). At least 1 and max 5 logo images can be specified.
     *
     * Generated from protobuf field <code>repeated .google.ads.googleads.v14.common.AdImageAsset logo_images = 4;</code>
     * @param array<\Google\Ads\GoogleAds\V14\Common\AdImageAsset>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setLogoImages($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Ads\GoogleAds\V14\Common\AdImageAsset::class);
        $this->logo_images = $arr;

        return $this;
    }

    /**
     * Headline text asset of the ad. Maximum display width is 30. At least 1 and
     * max 5 headlines can be specified.
     *
     * Generated from protobuf field <code>repeated .google.ads.googleads.v14.common.AdTextAsset headlines = 5;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getHeadlines()
    {
        return $this->headlines;
    }

    /**
     * Headline text asset of the ad. Maximum display width is 30. At least 1 and
     * max 5 headlines can be specified.
     *
     * Generated from protobuf field <code>repeated .google.ads.googleads.v14.common.AdTextAsset headlines = 5;</code>
     * @param array<\Google\Ads\GoogleAds\V14\Common\AdTextAsset>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setHeadlines($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Ads\GoogleAds\V14\Common\AdTextAsset::class);
        $this->headlines = $arr;

        return $this;
    }

    /**
     * The descriptive text of the ad. Maximum display width is 90. At least 1 and
     * max 5 descriptions can be specified.
     *
     * Generated from protobuf field <code>repeated .google.ads.googleads.v14.common.AdTextAsset descriptions = 6;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getDescriptions()
    {
        return $this->descriptions;
    }

    /**
     * The descriptive text of the ad. Maximum display width is 90. At least 1 and
     * max 5 descriptions can be specified.
     *
     * Generated from protobuf field <code>repeated .google.ads.googleads.v14.common.AdTextAsset descriptions = 6;</code>
     * @param array<\Google\Ads\GoogleAds\V14\Common\AdTextAsset>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setDescriptions($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Ads\GoogleAds\V14\Common\AdTextAsset::class);
        $this->descriptions = $arr;

        return $this;
    }

    /**
     * The Advertiser/brand name. Maximum display width is 25. Required.
     *
     * Generated from protobuf field <code>optional string business_name = 7;</code>
     * @return string
     */
    public function getBusinessName()
    {
        return isset($this->business_name) ? $this->business_name : '';
    }

    public function hasBusinessName()
    {
        return isset($this->business_name);
    }

    public function clearBusinessName()
    {
        unset($this->business_name);
    }

    /**
     * The Advertiser/brand name. Maximum display width is 25. Required.
     *
     * Generated from protobuf field <code>optional string business_name = 7;</code>
     * @param string $var
     * @return $this
     */
    public function setBusinessName($var)
    {
        GPBUtil::checkString($var, True);
        $this->business_name = $var;

        return $this;
    }

    /**
     * Call to action text.
     *
     * Generated from protobuf field <code>optional string call_to_action_text = 8;</code>
     * @return string
     */
    public function getCallToActionText()
    {
        return isset($this->call_to_action_text) ? $this->call_to_action_text : '';
    }

    public function hasCallToActionText()
    {
        return isset($this->call_to_action_text);
    }

    public function clearCallToActionText()
    {
        unset($this->call_to_action_text);
    }

    /**
     * Call to action text.
     *
     * Generated from protobuf field <code>optional string call_to_action_text = 8;</code>
     * @param string $var
     * @return $this
     */
    public function setCallToActionText($var)
    {
        GPBUtil::checkString($var, True);
        $this->call_to_action_text = $var;

        return $this;
    }

    /**
     * Boolean option that indicates if this ad must be served with lead form.
     *
     * Generated from protobuf field <code>optional bool lead_form_only = 9;</code>
     * @return bool
     */
    public function getLeadFormOnly()
    {
        return isset($this->lead_form_only) ? $this->lead_form_only : false;
    }

    public function hasLeadFormOnly()
    {
        return isset($this->lead_form_only);
    }

    public function clearLeadFormOnly()
    {
        unset($this->lead_form_only);
    }

    /**
     * Boolean option that indicates if this ad must be served with lead form.
     *
     * Generated from protobuf field <code>optional bool lead_form_only = 9;</code>
     * @param bool $var
     * @return $this
     */
    public function setLeadFormOnly($var)
    {
        GPBUtil::checkBool($var);
        $this->lead_form_only = $var;

        return $this;
    }

}

