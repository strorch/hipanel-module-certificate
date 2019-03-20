<?php

namespace hipanel\modules\certificate\tests\acceptance\client;

use hipanel\helpers\Url;
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Page\Widget\Input\Dropdown;
use hipanel\tests\_support\Page\Widget\Input\Input;
use hipanel\tests\_support\Step\Acceptance\Client;

class CertificatesCest
{
    /**
     * @var IndexPage
     */
    private $index;

    public function _before(Client $I)
    {
        $this->index = new IndexPage($I);
    }

    public function ensureIndexPageWorks(Client $I)
    {
        $I->login();
        $I->needPage(Url::to('@certificate'));
        $I->see('Certificates', 'h1');
        $this->ensureICanSeeAdvancedSearchBox($I);
        $this->ensureICanSeeBulkSearchBox();
    }

    private function ensureICanSeeAdvancedSearchBox(Client $I)
    {
        $this->index->containsFilters([
            (Dropdown::asAdvancedSearch($I, 'Type'))->withItems([
                'Comodo Code Signing SSL',
                'CPAC Basic',
                'GeoTrust QuickSSL Premium',
                'GoGetSSL TrialSSL',
                'Symantec Safe Site',
                'Ukrnames DomainSSL',
                'Certum Test ID',
            ]),
            (Dropdown::asAdvancedSearch($I, 'Status'))->withItems([
                'New',
                'Incomplete',
                'Pending',
                'Ok',
                'Expired',
                'Cancelled',
                'Error',
                'Deleted',
            ]),
            Input::asAdvancedSearch($I, 'Name'),
            new Input($I, '#certificatesearch-expires'),
        ]);
    }

    private function ensureICanSeeBulkSearchBox()
    {
        $this->index->containsColumns([
            'Certificate Type',
            'Name',
            'Status',
            'Expires',
        ]);
    }
}
