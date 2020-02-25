<?php

/**
 *
 * @package    EasyAds
 * @author     CodinBit <contact@codinbit.com>
 * @link       https://store.codinbit.com
 * @copyright  2017 EasyAds (https://store.codinbit.com)
 * @license    https://www.codinbit.com
 * @since      1.3
 */

namespace app\extensions\securityManager\components\mail\template;

class TemplateTypeSecurity implements TemplateTypeInterface
{
    const TEMPLATE_TYPE = 8;

    /**
     * @var array list of variables of template. You can set twig's filters that applied to variables. For more information check https://twig.symfony.com/doc/2.x/filters/index.html
     */
    protected $varsList = [
        'ban_reason'      => 'Reason of Ban',
        'recipient_email' => 'Recipient Email',
    ];

    protected $banReason;
    protected $recipientEmail;

    public function __construct(array $data)
    {
        if (!empty($data)) {
            $this->banReason      = $data['banReason'];
            $this->recipientEmail = $data['recipientEmail'];
        }
    }

    public function populate()
    {
        return [
            'ban_reason'      => $this->banReason,
            'recipient_email' => $this->recipientEmail,
        ];

    }

    public function getRecipient()
    {
        return $this->recipientEmail;
    }

    /**
     * @return array
     */
    public function getVarsList()
    {
        return $this->varsList;
    }
}