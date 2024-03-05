<?php

namespace Pashkevich\Wallet\Wallets\Google;

use Firebase\JWT\JWT;
use Google\Client as GoogleClient;
use Google\Service\Walletobjects\LoyaltyClass;
use Pashkevich\Wallet\Contracts\{Pass, Wallet};
use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\Service\{Exception as GoogleException,
    Walletobjects,
    Walletobjects\Barcode,
    Walletobjects\Image,
    Walletobjects\ImageModuleData,
    Walletobjects\ImageUri,
    Walletobjects\LatLongPoint,
    Walletobjects\LinksModuleData,
    Walletobjects\LocalizedString,
    Walletobjects\LoyaltyObject,
    Walletobjects\LoyaltyPoints,
    Walletobjects\LoyaltyPointsBalance,
    Walletobjects\TextModuleData,
    Walletobjects\TranslatedString,
    Walletobjects\Uri
};

class GoogleWallet implements Wallet
{
    /**
     * The Google API Client.
     *
     * @var GoogleClient
     */
    public GoogleClient $client;

    /**
     * Path to service account key file from Google Cloud Console.
     *
     * @var string
     */
    public string $keyFilePath;

    /**
     * Service account credentials for Google Wallet APIs.
     *
     * @var ServiceAccountCredentials
     */
    public ServiceAccountCredentials $credentials;

    /**
     * Google Wallet service client.
     *
     * @var Walletobjects
     */
    public Walletobjects $service;

    public function __construct(protected array $config)
    {
        $this->keyFilePath = $config['application_credentials_path'];

        $this->auth();
    }

    /**
     * Create authenticated HTTP client using a service account file.
     *
     * @return void
     */
    public function auth(): void
    {
        $this->credentials = new ServiceAccountCredentials(Walletobjects::WALLET_OBJECT_ISSUER, $this->keyFilePath);

        // Initialize Google Wallet API service
        $this->client = new GoogleClient();
        $this->client->setApplicationName('APPLICATION_NAME');
        $this->client->setScopes(Walletobjects::WALLET_OBJECT_ISSUER);
        $this->client->setAuthConfig($this->keyFilePath);

        $this->service = new Walletobjects($this->client);
    }

    /**
     * Create a class.
     *
     * @param string $issuerId The issuer ID being used for this request.
     * @param string $classSuffix Developer-defined unique ID for this pass class.
     *
     * @return string The pass class ID: "$issuerId.$classSuffix"
     */
    public function createClass(string $issuerId, string $classSuffix): string
    {
        // Check if the class exists
        try {
            $this->service->loyaltyclass->get("$issuerId.$classSuffix");

            return "$issuerId.$classSuffix";
        } catch (GoogleException $exception) {
            if (empty($exception->getErrors()) || $exception->getErrors()[0]['reason'] != 'classNotFound') {
                // Something else went wrong...
                return "$issuerId.$classSuffix";
            }
        }

        // See link below for more information on required properties
        // https://developers.google.com/wallet/retail/loyalty-cards/rest/v1/loyaltyclass
        $newClass = new LoyaltyClass([
            'id' => "$issuerId.$classSuffix",
            'issuerName' => 'Issuer name',
            'reviewStatus' => 'UNDER_REVIEW',
            'programName' => 'Program name',
            'programLogo' => new Image([
                'sourceUri' => new ImageUri([
                    'uri' => 'http://farm8.staticflickr.com/7340/11177041185_a61a7f2139_o.jpg'
                ]),
                'contentDescription' => new LocalizedString([
                    'defaultValue' => new TranslatedString([
                        'language' => 'en-US',
                        'value' => 'Logo description'
                    ])
                ])
            ])
        ]);

        $response = $this->service->loyaltyclass->insert($newClass);

        return $response->id;
    }

    /**
     * Create an object.
     *
     * @param string $issuerId The issuer ID being used for this request.
     * @param string $classSuffix Developer-defined unique ID for this pass class.
     * @param string $objectSuffix Developer-defined unique ID for this pass object.
     *
     * @return string The pass object ID: "$issuerId.$objectSuffix"
     */
    public function createObject(string $issuerId, string $classSuffix, string $objectSuffix): string
    {
        // Check if the object exists
        try {
            $this->service->loyaltyobject->get("$issuerId.$objectSuffix");

            return "$issuerId.$objectSuffix";
        } catch (GoogleException $exception) {
            if (empty($exception->getErrors()) || $exception->getErrors()[0]['reason'] != 'resourceNotFound') {
                // Something else went wrong...
                return "$issuerId.$objectSuffix";
            }
        }

        // See link below for more information on required properties
        // https://developers.google.com/wallet/retail/loyalty-cards/rest/v1/loyaltyobject
        $newObject = new LoyaltyObject([
            'id' => "$issuerId.$objectSuffix",
            'classId' => "$issuerId.$classSuffix",
            'state' => 'ACTIVE',
            'heroImage' => new Image([
                'sourceUri' => new ImageUri([
                    'uri' => 'https://farm4.staticflickr.com/3723/11177041115_6e6a3b6f49_o.jpg'
                ]),
                'contentDescription' => new LocalizedString([
                    'defaultValue' => new TranslatedString([
                        'language' => 'en-US',
                        'value' => 'Hero image description'
                    ])
                ])
            ]),
            'textModulesData' => [
                new TextModuleData([
                    'header' => 'Text module header',
                    'body' => 'Text module body',
                    'id' => 'TEXT_MODULE_ID'
                ])
            ],
            'linksModuleData' => new LinksModuleData([
                'uris' => [
                    new Uri([
                        'uri' => 'http://maps.google.com/',
                        'description' => 'Link module URI description',
                        'id' => 'LINK_MODULE_URI_ID'
                    ]),
                    new Uri([
                        'uri' => 'tel:6505555555',
                        'description' => 'Link module tel description',
                        'id' => 'LINK_MODULE_TEL_ID'
                    ])
                ]
            ]),
            'imageModulesData' => [
                new ImageModuleData([
                    'mainImage' => new Image([
                        'sourceUri' => new ImageUri([
                            'uri' => 'http://farm4.staticflickr.com/3738/12440799783_3dc3c20606_b.jpg'
                        ]),
                        'contentDescription' => new LocalizedString([
                            'defaultValue' => new TranslatedString([
                                'language' => 'en-US',
                                'value' => 'Image module description'
                            ])
                        ])
                    ]),
                    'id' => 'IMAGE_MODULE_ID'
                ])
            ],
            'barcode' => new Barcode([
                'type' => 'QR_CODE',
                'value' => 'QR code value'
            ]),
            'locations' => [
                new LatLongPoint([
                    'latitude' => 37.424015499999996,
                    'longitude' => -122.09259560000001
                ])
            ],
            'accountId' => 'Account ID',
            'accountName' => 'Account name',
            'loyaltyPoints' => new LoyaltyPoints([
                'balance' => new LoyaltyPointsBalance([
                    'int' => 800
                ])
            ])
        ]);

        $response = $this->service->loyaltyobject->insert($newObject);

        return $response->id;
    }

    /**
     * Generate a signed JWT that creates a new pass class and object.
     *
     * When the user opens the "Add to Google Wallet" URL and saves the pass to
     * their wallet, the pass class and object defined in the JWT are
     * created. This allows you to create multiple pass classes and objects in
     * one API call when the user saves the pass to their wallet.
     *
     * @param string $issuerId The issuer ID being used for this request.
     * @param string $classSuffix Developer-defined unique ID for the pass class.
     * @param string $objectSuffix Developer-defined unique ID for the pass object.
     *
     * @return string An "Add to Google Wallet" link.
     */
    public function createJwtNewObjects(string $issuerId, string $classSuffix, string $objectSuffix): string
    {
        // See link below for more information on required properties
        // https://developers.google.com/wallet/retail/loyalty-cards/rest/v1/loyaltyclass
        $newClass = new LoyaltyClass([
            'id' => "$issuerId.$classSuffix",
            'issuerName' => 'Issuer name',
            'reviewStatus' => 'UNDER_REVIEW',
            'programName' => 'Program name',
            'programLogo' => new Image([
                'sourceUri' => new ImageUri([
                    'uri' => 'http://farm8.staticflickr.com/7340/11177041185_a61a7f2139_o.jpg'
                ]),
                'contentDescription' => new LocalizedString([
                    'defaultValue' => new TranslatedString([
                        'language' => 'en-US',
                        'value' => 'Logo description'
                    ])
                ])
            ])
        ]);

        // See link below for more information on required properties
        // https://developers.google.com/wallet/retail/loyalty-cards/rest/v1/loyaltyobject
        $newObject = new LoyaltyObject([
            'id' => "$issuerId.$objectSuffix",
            'classId' => "$issuerId.$classSuffix",
            'state' => 'ACTIVE',
            'heroImage' => new Image([
                'sourceUri' => new ImageUri([
                    'uri' => 'https://farm4.staticflickr.com/3723/11177041115_6e6a3b6f49_o.jpg'
                ]),
                'contentDescription' => new LocalizedString([
                    'defaultValue' => new TranslatedString([
                        'language' => 'en-US',
                        'value' => 'Hero image description'
                    ])
                ])
            ]),
            'textModulesData' => [
                new TextModuleData([
                    'header' => 'Text module header',
                    'body' => 'Text module body',
                    'id' => 'TEXT_MODULE_ID'
                ])
            ],
            'linksModuleData' => new LinksModuleData([
                'uris' => [
                    new Uri([
                        'uri' => 'http://maps.google.com/',
                        'description' => 'Link module URI description',
                        'id' => 'LINK_MODULE_URI_ID'
                    ]),
                    new Uri([
                        'uri' => 'tel:6505555555',
                        'description' => 'Link module tel description',
                        'id' => 'LINK_MODULE_TEL_ID'
                    ])
                ]
            ]),
            'imageModulesData' => [
                new ImageModuleData([
                    'mainImage' => new Image([
                        'sourceUri' => new ImageUri([
                            'uri' => 'http://farm4.staticflickr.com/3738/12440799783_3dc3c20606_b.jpg'
                        ]),
                        'contentDescription' => new LocalizedString([
                            'defaultValue' => new TranslatedString([
                                'language' => 'en-US',
                                'value' => 'Image module description'
                            ])
                        ])
                    ]),
                    'id' => 'IMAGE_MODULE_ID'
                ])
            ],
            'barcode' => new Barcode([
                'type' => 'QR_CODE',
                'value' => 'QR code value'
            ]),
            'locations' => [
                new LatLongPoint([
                    'latitude' => 37.424015499999996,
                    'longitude' => -122.09259560000001
                ])
            ],
            'accountId' => 'Account ID',
            'accountName' => 'Account name',
            'loyaltyPoints' => new LoyaltyPoints([
                'balance' => new LoyaltyPointsBalance([
                    'int' => 800
                ])
            ])
        ]);

        // The service account credentials are used to sign the JWT
        $serviceAccount = json_decode(file_get_contents($this->keyFilePath), true);

        // Create the JWT as an array of key/value pairs
        $claims = [
            'iss' => $serviceAccount['client_email'],
            'aud' => 'google',
            'origins' => ['www.example.com'],
            'typ' => 'savetowallet',
            'payload' => [
                'loyaltyClasses' => [
                    $newClass,
                ],
                'loyaltyObjects' => [
                    $newObject,
                ],
            ],
        ];

        $token = JWT::encode($claims, $serviceAccount['private_key'], 'RS256');

        return "https://pay.google.com/gp/v/save/$token";
    }

    /**
     * Generate a signed JWT that references an existing pass object.
     *
     * When the user opens the "Add to Google Wallet" URL and saves the pass to
     * their wallet, the pass objects defined in the JWT are added to the
     * user's Google Wallet app. This allows the user to save multiple pass
     * objects in one API call.
     *
     * The objects to add must follow the below format:
     *
     *  {
     *    'id': 'ISSUER_ID.OBJECT_SUFFIX',
     *    'classId': 'ISSUER_ID.CLASS_SUFFIX'
     *  }
     *
     * @param string $issuerId The issuer ID being used for this request.
     *
     * @return string An "Add to Google Wallet" link.
     */
    public function createJwtExistingObjects(string $issuerId): string
    {
        // Multiple pass types can be added at the same time
        // At least one type must be specified in the JWT claims
        // Note: Make sure to replace the placeholder class and object suffixes
        $objectsToAdd = [
            // Loyalty cards
            'loyaltyObjects' => [
                [
                    'id' => "$issuerId.LOYALTY_OBJECT_SUFFIX",
                    'classId' => "$issuerId.LOYALTY_CLASS_SUFFIX"
                ]
            ],
        ];

        // The service account credentials are used to sign the JWT
        $serviceAccount = json_decode(file_get_contents($this->keyFilePath), true);

        // Create the JWT as an array of key/value pairs
        $claims = [
            'iss' => $serviceAccount['client_email'],
            'aud' => 'google',
            'origins' => ['www.example.com'],
            'typ' => 'savetowallet',
            'payload' => $objectsToAdd
        ];

        $token = JWT::encode($claims, $serviceAccount['private_key'], 'RS256');

        return "https://pay.google.com/gp/v/save/$token";
    }

    /**
     * Update a class.
     *
     * **Warning:** This replaces all existing class attributes!
     *
     * @param string $issuerId The issuer ID being used for this request.
     * @param string $classSuffix Developer-defined unique ID for this pass class.
     *
     * @return string The pass class ID: "{$issuerId}.{$classSuffix}"
     */
    public function updateClass(string $issuerId, string $classSuffix): string
    {
        return '';
    }

    /**
     * Patch a class.
     *
     * The PATCH method supports patch semantics.
     *
     * @param string $issuerId The issuer ID being used for this request.
     * @param string $classSuffix Developer-defined unique ID for this pass class.
     *
     * @return string The pass class ID: "{$issuerId}.{$classSuffix}"
     */
    public function patchClass(string $issuerId, string $classSuffix): string
    {
        return '';
    }

    public function createPass(Pass $pass): mixed
    {
        return null;
    }
}
