<?php

namespace GusApi\Tests\Util;

use GusApi\Type\Response\GetFullReportResponse;
use GusApi\Type\Response\GetFullReportResponseRaw;
use GusApi\Util\FullReportResponseDecoder;
use PHPUnit\Framework\TestCase;

class FullReportResponseDecoderTest extends TestCase
{
    public function testDecodeWithEmptyString()
    {
        $rawReport = new GetFullReportResponseRaw('');
        $reportDecoded = FullReportResponseDecoder::decode($rawReport);

        $this->assertInstanceOf(GetFullReportResponse::class, $reportDecoded);
        $this->assertEquals([], $reportDecoded->getReport());
    }

    public function testDecodeWithValidXMLObject()
    {
        $content = file_get_contents(__DIR__.'/../resources/response/fullSearchResponse.xsd');
        $rawReport = new GetFullReportResponseRaw($content);
        $reportDecoded = FullReportResponseDecoder::decode($rawReport);

        $this->assertInstanceOf(GetFullReportResponse::class, $reportDecoded);
        $this->assertEquals([
            [
                'fiz_regon9' => '666666666',
                'fiz_nazwa' => 'NIEPUBLICZNY ZAKŁAD OPIEKI ZDROWOTNEJ xxxxxxxxxxxxx',
                'fiz_nazwaSkrocona' => '',
                'fiz_dataPowstania' => '1993-03-20',
                'fiz_dataRozpoczeciaDzialalnosci' => '1999-10-20',
                'fiz_dataWpisuDoREGONDzialalnosci' => '',
                'fiz_dataZawieszeniaDzialalnosci' => '',
                'fiz_dataWznowieniaDzialalnosci' => '',
                'fiz_dataZaistnieniaZmianyDzialalnosci' => '2011-08-16',
                'fiz_dataZakonczeniaDzialalnosci' => '',
                'fiz_dataSkresleniazRegonDzialalnosci' => '',
                'fiz_adSiedzKraj_Symbol' => '',
                'fiz_adSiedzWojewodztwo_Symbol' => '30',
                'fiz_adSiedzPowiat_Symbol' => '22',
                'fiz_adSiedzGmina_Symbol' => '059',
                'fiz_adSiedzKodPocztowy' => '69000',
                'fiz_adSiedzMiejscowoscPoczty_Symbol' => '0198380',
                'fiz_adSiedzMiejscowosc_Symbol' => '0198380',
                'fiz_adSiedzUlica_Symbol' => '1240',
                'fiz_adSiedzNumerNieruchomosci' => '99',
                'fiz_adSiedzNumerLokalu' => '',
                'fiz_adSiedzNietypoweMiejsceLokalizacji' => '',
                'fiz_numerTelefonu' => '',
                'fiz_numerWewnetrznyTelefonu' => '',
                'fiz_numerFaksu' => '9999999999',
                'fiz_adresEmail' => '',
                'fiz_adresStronyinternetowej' => '',
                'fiz_adresEmail2' => '',
                'fiz_adSiedzKraj_Nazwa' => '',
                'fiz_adSiedzWojewodztwo_Nazwa' => 'WIELKOPOLSKIE',
                'fiz_adSiedzPowiat_Nazwa' => 'xxxxxxxxxx',
                'fiz_adSiedzGmina_Nazwa' => 'Yyyyyyyy',
                'fiz_adSiedzMiejscowosc_Nazwa' => 'Yyyyyyyy',
                'fiz_adSiedzMiejscowoscPoczty_Nazwa' => 'Yyyyyyyy',
                'fiz_adSiedzUlica_Nazwa' => 'ul. Adama Mickiewicza',
                'fizP_dataWpisuDoRejestruEwidencji' => '',
                'fizP_numerwRejestrzeEwidencji' => '',
                'fizP_OrganRejestrowy_Symbol' => '',
                'fizP_OrganRejestrowy_Nazwa' => '',
                'fizP_RodzajRejestru_Symbol' => '099',
                'fizP_RodzajRejestru_Nazwa' => 'PODMIOTY NIE PODLEGAJĄCE WPISOM DO REJESTRU LUB EWIDENCJI',
            ],
        ], $reportDecoded->getReport());
    }

    /**
     * @expectedException \GusApi\Exception\InvalidServerResponseException
     */
    public function testInvalidServerResponse()
    {
        $rawReport = new GetFullReportResponseRaw('Invalid XML structure');
        FullReportResponseDecoder::decode($rawReport);
    }
}
