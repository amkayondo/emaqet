<?php

/**
 *
 * @package    EasyAds
 * @author     CodinBit <contact@codinbit.com>
 * @link       https://store.codinbit.com
 * @copyright  2017 EasyAds (https://store.codinbit.com)
 * @license    https://www.codinbit.com
 * @since      1.4
 */

namespace app\components\mail\template;

/**
 * Class TemplateTypeGeneral
 * @package app\components\mail\template
 */
class TemplateTypeGeneral implements TemplateTypeInterface
{
    const TEMPLATE_TYPE = 9;

    /**
     * @var array list of variables of template
     */
    protected $varsList = [
        'sender_first_name'             => 'Sender First Name',
        'sender_last_name'              => 'Sender Last Name',
        'sender_full_name'              => 'Sender Full Name',
        'sender_email'                  => 'Sender Email',
        'receiver_first_name'           => 'receiver First Name',
        'receiver_last_name'            => 'receiver Last Name',
        'receiver_full_name'            => 'receiver Full Name',
        'receiver_email'                => 'receiver Email',
        'message | raw'                 => 'Message'
    ];

    protected $senderFirstName;
    protected $senderLastName;
    protected $senderFullName;
    protected $senderEmail;
    protected $receiverFirstName;
    protected $receiverLastName;
    protected $receiverFullName;
    protected $receiverEmail;
    protected $message;


    public function __construct(array $data)
    {
        if (!empty($data)) {
            $this->senderFirstName      = $data['sender_first_name'];
            $this->senderLastName       = $data['sender_last_name'];
            $this->senderFullName       = $data['sender_full_name'];
            $this->senderEmail          = $data['sender_email'];
            $this->receiverFirstName    = $data['receiver_first_name'];
            $this->receiverLastName     = $data['receiver_last_name'];
            $this->receiverFullName     = $data['receiver_full_name'];
            $this->receiverEmail        = $data['receiver_email'];
            $this->message              = $data['message'];

        }
    }

    public function populate()
    {
        return[
            'sender_first_name'     => $this->senderFirstName,
            'sender_last_name'      => $this->senderLastName,
            'sender_full_name'      => $this->senderFullName,
            'sender_email'          => $this->senderEmail,
            'receiver_first_name'   => $this->receiverFirstName,
            'receiver_last_name'    => $this->receiverLastName,
            'receiver_full_name'    => $this->receiverFullName,
            'receiver_email'        => $this->receiverEmail,
            'message'               => $this->message,
        ];

    }

    public function getRecipient()
    {
        return $this->receiverEmail;
    }

    /**
     * @return array
     */
    public function getVarsList()
    {
        return $this->varsList;
    }
}