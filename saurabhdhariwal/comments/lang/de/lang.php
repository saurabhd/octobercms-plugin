<?php 

return [
    'plugin' => [
        'name' => 'Kommentare',
        'description' => 'Ermöglicht es Benutzern zu kommentieren',
    ],
    
    'comment' => [
        'author' => 'Autor',
        'content' => 'Inhalt',
        'status' => 'Status',
        'comments' => 'Kommentare',
        'status_approved' => 'Veröffentlicht',
        'status_pending' => 'Zu kontrollieren',
        'status_spam' => 'Spam',
    ],
    'settings' => [
        'allow_guest_label' => 'Erlaube Gäste',
        'allow_guest_above' => 'Gäste können Beiträge kommentieren',
        'status_label' => 'Status',
        'status_above' => 'Standardmäßiger Status für neue Kommentare',
        'section_recaptcha_label' => 'reCAPTCHA Einstellungen',
        'section_recaptcha_comments' => 'Zeigt oder versteckt reCAPTCHA auf den Formular',
        'recaptcha_label' => 'reCAPTCHA',
        'recaptcha_comment' => 'Zeige reCAPTCHA widget auf den Formular',
        'site_key_label' => 'Site Key',
        'site_key_comment' => 'Site key von Google',
        'secret_key_label' => 'Secret Key',
        'secret_key_comment' => 'Secret key von Google'
    ]
];