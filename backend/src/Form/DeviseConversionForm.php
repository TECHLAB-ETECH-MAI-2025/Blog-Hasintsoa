<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Range;

class DeviseConversionForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $devisesList = [
            'Dollar américain' => 'USD',
            'euro' => 'EUR',
            'Yen japonais' => 'JPY',
            'Livre sterling' => 'GBP',
            'Dollar australien' => 'AUD',
            'Dollar canadien' => 'CAD',
            'Franc suisse' => 'CHF',
            'Chine Yuan Renminbi' => 'CNY',
            'couronne suédoise' => 'SEK',
            's devises' => 'Toutes',
            'Dirham des Émirats Arabes Unis' => 'AED',
            'Afghanistan afghan' => 'AFN',
            'Lek albanais' => 'ALL',
            'Dram arménien' => 'AMD',
            'Kwanza angolais' => 'AOA',
            'Peso argentin' => 'ARS',
            'Florin d\'Aruba' => 'AWG',
            'Manat azerbaïdjanais' => 'AZN',
            'Cabriolet bosniaque' => 'BAM',
            'Dollar de la Barbade' => 'BBD',
            'Taka du Bangladesh' => 'BDT',
            'Lev bulgare' => 'BGN',
            'Dinar de Bahreïn' => 'BHD',
            'Franc burundais' => 'BIF',
            'Dollar des Bermudes' => 'BMD',
            'Dollar de Brunei' => 'BND',
            'Boliviano bolivien' => 'BOB',
            'Réal brésilien' => 'BRL',
            'Dollar des Bahamas' => 'BSD',
            'Bhoutan Ngultrum' => 'BTN',
            'Pula du Botswana' => 'BWP',
            'Rouble biélorusse' => 'BYN',
            'Dollar bélizéen' => 'BZD',
            'franc congolais' => 'CDF',
            'Peso chilien' => 'CLP',
            'Peso colombien' => 'COP',
            'Colon du Costa Rica' => 'CRC',
            'Escudo du Cap-Vert' => 'CVE',
            'Livre chypriote' => 'CYP',
            'Couronne tchèque' => 'CZK',
            'Franc djiboutien' => 'DJF',
            'couronne danoise' => 'DKK',
            'Peso dominicain' => 'DOP',
            'Dinar algérien' => 'DZD',
            'Couronne estonienne' => 'EEK',
            'Livre égyptienne' => 'EGP',
            'Nafka érythréenne' => 'ERN',
            'Birr éthiopien' => 'ETB',
            'Dollar fidjien' => 'FJD',
            'Falkland est. Broyer' => 'FKP',
            'Lari géorgien' => 'GEL',
            'Cedi ghanéen' => 'GHS',
            'Livre de Gibraltar' => 'GIP',
            'Dalasi gambien' => 'GMD',
            'Franc guinéen' => 'GNF',
            'Éqguinée Ekwele' => 'GQE',
            'Quetzal guatémaltèque' => 'GTQ',
            'GuinéeBissau Peso' => 'GWP',
            'Dollar guyanais' => 'GYD',
            'Dollar de Hong Kong' => 'HKD',
            'Lempira du Honduras' => 'HNL',
            'Kuna croate' => 'HRK',
            'Haïti Gourde' => 'HTG',
            'Hongrie Forint' => 'HUF',
            'Roupie indonésienne' => 'IDR',
            'Nouveau shekel israélien' => 'ILS',
            'roupie indienne' => 'INR',
            'Dinar irakien' => 'IQD',
            'Rial iranien' => 'IRR',
            'Couronne islandaise' => 'ISK',
            'Dollar jamaïcain' => 'JMD',
            'Dinar jordanien' => 'JOD',
            'Shilling kényan' => 'KES',
            'Kirghizistan Som' => 'KGS',
            'Cambodge Riel' => 'KHR',
            'Franc comorien' => 'KMF',
            'Corée du Sud a gagné' => 'KRW',
            'Dinar koweïtien' => 'KWD',
            'Caïman est. Dollar' => 'KYD',
            'Tenge kazakh' => 'KZT',
            'Kip laotien' => 'LAK',
            'Livre libanaise' => 'LBP',
            'Roupie de Sri Lanka' => 'LKR',
            'Dollar libérien' => 'LRD',
            'Loti du Lesotho' => 'LSL',
            'Litas lituanien' => 'LTL',
            'Lats lettons' => 'LVL',
            'Dinar libyen' => 'LYD',
            'Dirham marocain' => 'MAD',
            'Leu moldave' => 'MDL',
            'Ariary malgache' => 'MGA',
            'Denar macédonien' => 'MKD',
            'Kyat du Myanmar' => 'MMK',
            'Mongolie Tugrik' => 'MNT',
            'Pataca de Macao' => 'MOP',
            'Mauritanie Ouguiya' => 'MRO',
            'Lire maltaise' => 'MTL',
            'Roupie mauricienne' => 'MUR',
            'Rufiyaa des Maldives' => 'MVR',
            'Kwacha malawite' => 'MWK',
            'Peso mexicain' => 'MXN',
            'cloche malaisienne' => 'MYR',
            'Metical mozambicain' => 'MZN',
            'Dollar namibien' => 'NAD',
            'Naira nigérian' => 'NGN',
            'Nicarag Cordoue Oro' => 'NIO',
            'Couronne norvégienne' => 'NOK',
            'Roupie népalaise' => 'NPR',
            'Dollar néo-zélandais' => 'NZD',
            'Rial d\'Oman' => 'OMR',
            'Panamá Balboa' => 'PAB',
            'Pérou Nuevo Sol' => 'PEN',
            'Papouasie Ng Kina' => 'PGK',
            'Peso philippin' => 'PHP',
            'Roupie pakistanaise' => 'PKR',
            'Nouveau zloty polonais' => 'PLN',
            'Guarani du Paraguay' => 'PYG',
            'Rial du Qatar' => 'QAR',
            'Lei roumain' => 'RON',
            'Dinar serbe' => 'RSD',
            'Rouble russe' => 'RUB',
            'Franc rwandais' => 'RWF',
            'Rial saoudien' => 'SAR',
            'Salomon est. Dollar' => 'SBD',
            'Roupie seychelloise' => 'SCR',
            'livre soudanaise' => 'SDG',
            'Dollar de Singapour' => 'SGD',
            'Livre de Sainte-Hélène' => 'SHP',
            'Tolar slovène' => 'SIT',
            'Couronne slovaque' => 'SKK',
            'Sierra Leone' => 'SLL',
            'Shilling somalien' => 'SOS',
            'Dollar du Surinam' => 'SRD',
            'Livre sud-soudanaise' => 'SSP',
            'Dobra de Sao Tomé' => 'STD',
            'Colon salvadorien' => 'SVC',
            'Livre syrienne' => 'SYP',
            'Swazi Lilangeni' => 'SZL',
            'Baht thaïlandais' => 'THB',
            'Tadjikistan Somoni' => 'TJS',
            'Manat du Turkménistan' => 'TMT',
            'Dinar tunisien' => 'TND',
            'Tonga Paanga' => 'TOP',
            'Lire turque' => 'TRY',
            'TrinidadTobago Dol.' => 'TTD',
            'Nouveau dollar taïwanais' => 'TWD',
            'Shilling tanzanien' => 'TZS',
            'Hryvnia ukrainienne' => 'UAH',
            'Shilling ougandais' => 'UGX',
            'Peso uruguayen' => 'UYU',
            'Somme d\'Ouzbékistan' => 'UZS',
            'Venez Bolivar Fuerte' => 'VEF',
            'Bolívar Soberano' => 'VES',
            'Vietnam Dong' => 'VND',
            'Vanuatu Vatu' => 'VUV',
            'Tala de Samoa' => 'WST',
            'Franc Cfa Beac' => 'XAF',
            'E. Dollar des Caraïbes' => 'XCD',
            'Guiltre des Caraïbes' => 'XCG',
            'Franc Cfa BCEAO' => 'XOF',
            'Franc CFP' => 'XPF',
            'Rial yéménite' => 'YER',
            'Rand sud-africain' => 'ZAR',
            'Kwacha zambien' => 'ZMW',
            'Or du Zimbabwe' => 'ZWG',
            'Dollar zimbabwéen' => 'ZWL',
        ];

        $builder
            ->add('amount', NumberType::class, [
                'label' => 'Montant que vous avez payé',
                'constraints' => [
                    new NotNull([
                        'message' => 'Veuillez entrer un montant',
                    ]),
                    new Positive([
                        'message' => 'Le montant doit être positif',
                    ]),
                ]
            ])
            ->add('fee', NumberType::class, [
                'label' => 'frais bancaires (%)',
                'constraints' => [
                    new NotNull([
                        'message' => 'Veuillez entrer un pourcentage',
                    ]),
                    new Range([
                        'min' => 0,
                        'max' => 100,
                        'notInRangeMessage' => 'Le nombre doit être entre {{ min }} et {{ max }}.',
                    ]),
                ]
            ])
            ->add('exchangedate', DateType::class, [
                'label'=> 'Date de transaction',
                'constraints' => [
                    new NotNull([
                        'message' => 'Veuillez entrer la date de l\'échange',
                    ]),
                ]
            ])
            ->add('fromCurr', ChoiceType::class, [
                'label' => 'De',
                'choices' => $devisesList,
                'constraints' => [
                    new NotNull([
                        'message' => 'Veuillez sélectionner une devise',
                    ]),
                ]
            ])
            ->add('toCurr', ChoiceType::class, [
                'label' => 'à',
                'choices' => $devisesList,
                'constraints' => [
                    new NotNull([
                        'message' => 'Veuillez sélectionner une devise',
                    ]),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
