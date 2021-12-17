<?php
namespace Beatom\DataSeo;

use Illuminate\Support\Facades\DB;

class DataSeo {

    const configTable = [
            'excluded_target' => 30,
            'target_domain' => 30,
            'referring_domain' => 30,
            'rank' => 7,
            'first_seen' => 30,
            'lost_date' => 30,
        ];
    const lenghTable = 162;
    const LOG_TABLE = 'log_data_seo';


    protected $apiUrl = 'https://api.dataforseo.com/';
    protected $client;
    protected $domainsClient;
    protected $excludeTargetsClient;

    protected $domains;
    protected $excludeTargets;

    public $result = [];


    public function __construct( string $domains, $excludeTargets = null){

        require_once 'RestClient/RestClient.php';

        $this->domains = $domains;
        $this->domainsClient = $this->convertParam($domains, true);
        $this->excludeTargets = $excludeTargets;
        $this->excludeTargetsClient = $this->convertParam($excludeTargets);

        $this->client = new \RestClient(
            $this->apiUrl,
            null,
            config('dataseo.login'),
            config('dataseo.password')
        );
    }

    /**
     * build param fo API
     * @param string|null $param
     * @param bool $setKey
     * @return array
     */
    private function convertParam($param, $setKey = false){
        $out = [];

        if(!$param){
            return $param;
        }

        $param = str_replace(' ', '', $param);
        $param = explode(',', $param);

        if($setKey){
            for ($i=0; $i < count($param); $i++){
                $out[$i+1] = $param[$i];
            }
        }
        else{
            $out = $param;
        }

        return $out;
    }

    public function getDataSeo() {

        if(empty($this->domainsClient)){
            throw new \Exception('Target empty');
        }

        $postData = [
            "targets" => $this->domainsClient,
            "limit" => 10,
            "include_subdomains" => false,
            "exclude_internal_backlinks" => true,
            "order_by" => [
                "1.rank,desc"
            ]
        ];
        if(!empty($this->excludeTargetsClient)){
            $postData['exclude_targets'] = $this->excludeTargetsClient;
        }

        $postArray = [];
        $postArray[] = $postData;

        try {
            // POST /v3/backlinks/domain_intersection/live
//            $this->result = $this->client->post('/v3/backlinks/domain_intersection/live', $postArray);
//            var_dump($this->result);

//            $result = '{"version":"0.1.20211130","status_code":20000,"status_message":"Ok.","time":"0.9961 sec.","cost":0.0203,"tasks_count":1,"tasks_error":0,"tasks":[{"id":"12171302-3362-0268-0000-3c32c858067a","status_code":20000,"status_message":"Ok.","time":"0.9289 sec.","cost":0.0203,"result_count":1,"path":["v3","backlinks","domain_intersection","live"],"data":{"api":"backlinks","function":"domain_intersection","targets":{"1":"expressvpn.com","2":"nordvpn.com"},"limit":10,"include_subdomains":false,"exclude_internal_backlinks":true,"order_by":["1.rank,desc"],"exclude_targets":["protonvpn.com"]},"result":[{"targets":{"1":"expressvpn.com","2":"nordvpn.com"},"total_count":6462,"items_count":10,"items":[{"1":{"type":"backlinks_domain_intersection","target":"wongqq.net","rank":343,"backlinks":9,"first_seen":"2021-08-27 20:28:54 +00:00","lost_date":null,"broken_backlinks":0,"broken_pages":0,"referring_domains":1,"referring_main_domains":1,"referring_ips":1,"referring_subnets":1,"referring_pages":3,"referring_links_tld":{"net":3},"referring_links_types":{"anchor":2,"redirect":1},"referring_links_attributes":null,"referring_links_platform_types":{"blogs":2,"cms":2},"referring_links_semantic_locations":{"article":2,"":1}},"2":{"type":"backlinks_domain_intersection","target":"wongqq.net","rank":0,"backlinks":1,"first_seen":"2021-10-24 18:01:21 +00:00","lost_date":null,"broken_backlinks":0,"broken_pages":0,"referring_domains":1,"referring_main_domains":1,"referring_ips":1,"referring_subnets":1,"referring_pages":1,"referring_links_tld":{"net":1},"referring_links_types":{"redirect":1},"referring_links_attributes":null,"referring_links_platform_types":null,"referring_links_semantic_locations":{"":1}}},{"1":{"type":"backlinks_domain_intersection","target":"www.vpnnologs.com","rank":285,"backlinks":15,"first_seen":"2019-07-21 06:25:58 +00:00","lost_date":null,"broken_backlinks":0,"broken_pages":0,"referring_domains":1,"referring_main_domains":1,"referring_ips":1,"referring_subnets":1,"referring_pages":15,"referring_links_tld":{"com":15},"referring_links_types":{"anchor":15},"referring_links_attributes":null,"referring_links_platform_types":{"unknown":15},"referring_links_semantic_locations":{"section":15}},"2":{"type":"backlinks_domain_intersection","target":"www.vpnnologs.com","rank":284,"backlinks":11,"first_seen":"2019-07-21 06:25:58 +00:00","lost_date":null,"broken_backlinks":0,"broken_pages":0,"referring_domains":1,"referring_main_domains":1,"referring_ips":1,"referring_subnets":1,"referring_pages":11,"referring_links_tld":{"com":11},"referring_links_types":{"anchor":11},"referring_links_attributes":null,"referring_links_platform_types":{"unknown":11},"referring_links_semantic_locations":{"section":11}}},{"1":{"type":"backlinks_domain_intersection","target":"www.asiabet8888.com","rank":252,"backlinks":1,"first_seen":"2020-01-24 20:26:27 +00:00","lost_date":null,"broken_backlinks":0,"broken_pages":0,"referring_domains":1,"referring_main_domains":1,"referring_ips":1,"referring_subnets":1,"referring_pages":1,"referring_links_tld":{"com":1},"referring_links_types":{"anchor":1},"referring_links_attributes":null,"referring_links_platform_types":{"unknown":1},"referring_links_semantic_locations":{"article":1}},"2":{"type":"backlinks_domain_intersection","target":"www.asiabet8888.com","rank":252,"backlinks":1,"first_seen":"2020-01-24 20:26:27 +00:00","lost_date":null,"broken_backlinks":0,"broken_pages":0,"referring_domains":1,"referring_main_domains":1,"referring_ips":1,"referring_subnets":1,"referring_pages":1,"referring_links_tld":{"com":1},"referring_links_types":{"anchor":1},"referring_links_attributes":null,"referring_links_platform_types":{"unknown":1},"referring_links_semantic_locations":{"article":1}}},{"1":{"type":"backlinks_domain_intersection","target":"www.whatismyanipaddress.com","rank":246,"backlinks":2,"first_seen":"2021-09-09 04:02:07 +00:00","lost_date":null,"broken_backlinks":0,"broken_pages":0,"referring_domains":1,"referring_main_domains":1,"referring_ips":1,"referring_subnets":1,"referring_pages":2,"referring_links_tld":{"com":2},"referring_links_types":{"anchor":2},"referring_links_attributes":null,"referring_links_platform_types":{"blogs":2,"cms":2},"referring_links_semantic_locations":{"article":2}},"2":{"type":"backlinks_domain_intersection","target":"www.whatismyanipaddress.com","rank":246,"backlinks":2,"first_seen":"2021-09-09 04:02:07 +00:00","lost_date":null,"broken_backlinks":0,"broken_pages":0,"referring_domains":1,"referring_main_domains":1,"referring_ips":1,"referring_subnets":1,"referring_pages":2,"referring_links_tld":{"com":2},"referring_links_types":{"anchor":2},"referring_links_attributes":null,"referring_links_platform_types":{"blogs":2,"cms":2},"referring_links_semantic_locations":{"article":2}}},{"1":{"type":"backlinks_domain_intersection","target":"www.bestvpnaustralia.com.au","rank":226,"backlinks":1172,"first_seen":"2020-08-08 14:00:31 +00:00","lost_date":null,"broken_backlinks":0,"broken_pages":0,"referring_domains":1,"referring_main_domains":1,"referring_ips":2,"referring_subnets":2,"referring_pages":261,"referring_links_tld":{"com.au":261},"referring_links_types":{"anchor":261},"referring_links_attributes":null,"referring_links_platform_types":{"blogs":261,"cms":261},"referring_links_semantic_locations":{"":261}},"2":{"type":"backlinks_domain_intersection","target":"www.bestvpnaustralia.com.au","rank":173,"backlinks":395,"first_seen":"2019-07-17 07:07:07 +00:00","lost_date":null,"broken_backlinks":0,"broken_pages":0,"referring_domains":1,"referring_main_domains":1,"referring_ips":2,"referring_subnets":2,"referring_pages":198,"referring_links_tld":{"com.au":198},"referring_links_types":{"anchor":197,"redirect":1},"referring_links_attributes":{"noopener":197,"noreferrer":197},"referring_links_platform_types":{"blogs":197,"cms":197},"referring_links_semantic_locations":{"":198}}},{"1":{"type":"backlinks_domain_intersection","target":"pckeepclean.com","rank":223,"backlinks":9,"first_seen":"2021-08-27 14:51:04 +00:00","lost_date":null,"broken_backlinks":0,"broken_pages":0,"referring_domains":1,"referring_main_domains":1,"referring_ips":1,"referring_subnets":1,"referring_pages":3,"referring_links_tld":{"com":3},"referring_links_types":{"anchor":2,"redirect":1},"referring_links_attributes":null,"referring_links_platform_types":{"blogs":2,"cms":2},"referring_links_semantic_locations":{"article":2,"":1}},"2":{"type":"backlinks_domain_intersection","target":"pckeepclean.com","rank":0,"backlinks":1,"first_seen":"2021-09-27 20:22:07 +00:00","lost_date":null,"broken_backlinks":0,"broken_pages":0,"referring_domains":1,"referring_main_domains":1,"referring_ips":1,"referring_subnets":1,"referring_pages":1,"referring_links_tld":{"com":1},"referring_links_types":{"redirect":1},"referring_links_attributes":null,"referring_links_platform_types":null,"referring_links_semantic_locations":{"":1}}},{"1":{"type":"backlinks_domain_intersection","target":"parlarispa.com","rank":206,"backlinks":769,"first_seen":"2021-07-28 19:58:03 +00:00","lost_date":null,"broken_backlinks":0,"broken_pages":0,"referring_domains":1,"referring_main_domains":1,"referring_ips":2,"referring_subnets":2,"referring_pages":479,"referring_links_tld":{"com":479},"referring_links_types":{"anchor":479},"referring_links_attributes":{"noopener":70,"noreferrer":36},"referring_links_platform_types":{"unknown":479},"referring_links_semantic_locations":{"":479}},"2":{"type":"backlinks_domain_intersection","target":"parlarispa.com","rank":0,"backlinks":17,"first_seen":"2021-06-21 01:35:05 +00:00","lost_date":null,"broken_backlinks":0,"broken_pages":0,"referring_domains":1,"referring_main_domains":1,"referring_ips":2,"referring_subnets":2,"referring_pages":12,"referring_links_tld":{"com":12},"referring_links_types":{"anchor":12},"referring_links_attributes":{"noopener":8,"noreferrer":2},"referring_links_platform_types":{"unknown":12},"referring_links_semantic_locations":{"":12}}},{"1":{"type":"backlinks_domain_intersection","target":"yzcr.cc","rank":199,"backlinks":378,"first_seen":"2021-02-26 06:05:14 +00:00","lost_date":null,"broken_backlinks":0,"broken_pages":0,"referring_domains":1,"referring_main_domains":1,"referring_ips":1,"referring_subnets":1,"referring_pages":378,"referring_links_tld":{"cc":378},"referring_links_types":{"anchor":378},"referring_links_attributes":null,"referring_links_platform_types":{"unknown":378},"referring_links_semantic_locations":{"":378}},"2":{"type":"backlinks_domain_intersection","target":"yzcr.cc","rank":199,"backlinks":378,"first_seen":"2021-02-26 06:05:14 +00:00","lost_date":null,"broken_backlinks":0,"broken_pages":0,"referring_domains":1,"referring_main_domains":1,"referring_ips":1,"referring_subnets":1,"referring_pages":378,"referring_links_tld":{"cc":378},"referring_links_types":{"anchor":378},"referring_links_attributes":null,"referring_links_platform_types":{"unknown":378},"referring_links_semantic_locations":{"":378}}},{"1":{"type":"backlinks_domain_intersection","target":"softwarekeep.com","rank":188,"backlinks":1,"first_seen":"2021-10-24 19:59:09 +00:00","lost_date":null,"broken_backlinks":0,"broken_pages":0,"referring_domains":1,"referring_main_domains":1,"referring_ips":1,"referring_subnets":1,"referring_pages":1,"referring_links_tld":{"com":1},"referring_links_types":{"anchor":1},"referring_links_attributes":null,"referring_links_platform_types":{"unknown":1},"referring_links_semantic_locations":{"section":1}},"2":{"type":"backlinks_domain_intersection","target":"softwarekeep.com","rank":188,"backlinks":1,"first_seen":"2021-10-24 19:59:09 +00:00","lost_date":null,"broken_backlinks":0,"broken_pages":0,"referring_domains":1,"referring_main_domains":1,"referring_ips":1,"referring_subnets":1,"referring_pages":1,"referring_links_tld":{"com":1},"referring_links_types":{"anchor":1},"referring_links_attributes":null,"referring_links_platform_types":{"unknown":1},"referring_links_semantic_locations":{"section":1}}},{"1":{"type":"backlinks_domain_intersection","target":"tawdif.pro","rank":187,"backlinks":686,"first_seen":"2021-12-03 02:50:01 +00:00","lost_date":null,"broken_backlinks":0,"broken_pages":0,"referring_domains":1,"referring_main_domains":1,"referring_ips":1,"referring_subnets":1,"referring_pages":684,"referring_links_tld":{"pro":684},"referring_links_types":{"anchor":684},"referring_links_attributes":{"noopener":680,"noreferrer":678,"nofollow":492},"referring_links_platform_types":{"blogs":684,"cms":684},"referring_links_semantic_locations":{"article":670,"figure":14}},"2":{"type":"backlinks_domain_intersection","target":"tawdif.pro","rank":23,"backlinks":2,"first_seen":"2021-12-03 03:35:23 +00:00","lost_date":null,"broken_backlinks":0,"broken_pages":0,"referring_domains":1,"referring_main_domains":1,"referring_ips":1,"referring_subnets":1,"referring_pages":2,"referring_links_tld":{"pro":2},"referring_links_types":{"anchor":2},"referring_links_attributes":{"noopener":2},"referring_links_platform_types":{"blogs":2,"cms":2},"referring_links_semantic_locations":{"article":2}}}]}]}]}';
            $result = '{"version":"0.1.20211130","status_code":20000,"status_message":"Ok.","time":"0.8145 sec.","cost":0.0203,"tasks_count":1,"tasks_error":0,"tasks":[{"id":"12171208-3362-0268-0000-76234395ad83","status_code":20000,"status_message":"Ok.","time":"0.7681 sec.","cost":0.0203,"result_count":1,"path":["v3","backlinks","domain_intersection","live"],"data":{"api":"backlinks","function":"domain_intersection","targets":{"1":"expressvpn.com","2":"nordvpn.com"},"limit":10,"include_subdomains":false,"exclude_internal_backlinks":true,"order_by":["1.rank,desc"]},"result":[{"targets":{"1":"expressvpn.com","2":"nordvpn.com"},"total_count":9187,"items_count":10,"items":[{"1":{"type":"backlinks_domain_intersection","target":"wongqq.net","rank":343,"backlinks":9,"first_seen":"2021-08-27 20:28:54 +00:00","lost_date":null,"broken_backlinks":0,"broken_pages":0,"referring_domains":1,"referring_main_domains":1,"referring_ips":1,"referring_subnets":1,"referring_pages":3,"referring_links_tld":{"net":3},"referring_links_types":{"anchor":2,"redirect":1},"referring_links_attributes":null,"referring_links_platform_types":{"blogs":2,"cms":2},"referring_links_semantic_locations":{"article":2,"":1}},"2":{"type":"backlinks_domain_intersection","target":"wongqq.net","rank":0,"backlinks":1,"first_seen":"2021-10-24 18:01:21 +00:00","lost_date":null,"broken_backlinks":0,"broken_pages":0,"referring_domains":1,"referring_main_domains":1,"referring_ips":1,"referring_subnets":1,"referring_pages":1,"referring_links_tld":{"net":1},"referring_links_types":{"redirect":1},"referring_links_attributes":null,"referring_links_platform_types":null,"referring_links_semantic_locations":{"":1}}},{"1":{"type":"backlinks_domain_intersection","target":"forum.fok.nl","rank":328,"backlinks":18770,"first_seen":"2019-01-22 14:25:05 +00:00","lost_date":null,"broken_backlinks":0,"broken_pages":0,"referring_domains":1,"referring_main_domains":1,"referring_ips":3,"referring_subnets":3,"referring_pages":5260,"referring_links_tld":{"nl":5260},"referring_links_types":{"anchor":5260},"referring_links_attributes":{"nofollow":3},"referring_links_platform_types":{"unknown":5260},"referring_links_semantic_locations":{"":5260}},"2":{"type":"backlinks_domain_intersection","target":"forum.fok.nl","rank":332,"backlinks":19067,"first_seen":"2019-01-17 23:36:35 +00:00","lost_date":null,"broken_backlinks":0,"broken_pages":0,"referring_domains":1,"referring_main_domains":1,"referring_ips":3,"referring_subnets":3,"referring_pages":5310,"referring_links_tld":{"nl":5310},"referring_links_types":{"anchor":5310},"referring_links_attributes":{"nofollow":2},"referring_links_platform_types":{"unknown":5310},"referring_links_semantic_locations":{"":5310}}},{"1":{"type":"backlinks_domain_intersection","target":"jalantikus.com","rank":323,"backlinks":6709,"first_seen":"2020-05-30 06:48:15 +00:00","lost_date":null,"broken_backlinks":0,"broken_pages":0,"referring_domains":1,"referring_main_domains":1,"referring_ips":1,"referring_subnets":1,"referring_pages":6708,"referring_links_tld":{"com":6708},"referring_links_types":{"anchor":6708},"referring_links_attributes":null,"referring_links_platform_types":{"unknown":6708},"referring_links_semantic_locations":{"main":6706,"section":2}},"2":{"type":"backlinks_domain_intersection","target":"jalantikus.com","rank":13,"backlinks":3,"first_seen":"2021-09-08 11:47:50 +00:00","lost_date":null,"broken_backlinks":0,"broken_pages":0,"referring_domains":1,"referring_main_domains":1,"referring_ips":1,"referring_subnets":1,"referring_pages":3,"referring_links_tld":{"com":3},"referring_links_types":{"anchor":3},"referring_links_attributes":null,"referring_links_platform_types":{"unknown":3},"referring_links_semantic_locations":{"main":2,"section":1}}},{"1":{"type":"backlinks_domain_intersection","target":"bit.ly","rank":313,"backlinks":14,"first_seen":"2019-01-19 18:16:24 +00:00","lost_date":null,"broken_backlinks":0,"broken_pages":0,"referring_domains":1,"referring_main_domains":1,"referring_ips":2,"referring_subnets":1,"referring_pages":14,"referring_links_tld":{"ly":14},"referring_links_types":{"redirect":14},"referring_links_attributes":null,"referring_links_platform_types":null,"referring_links_semantic_locations":{"":14}},"2":{"type":"backlinks_domain_intersection","target":"bit.ly","rank":360,"backlinks":13,"first_seen":"2019-02-21 00:35:24 +00:00","lost_date":null,"broken_backlinks":0,"broken_pages":0,"referring_domains":1,"referring_main_domains":1,"referring_ips":2,"referring_subnets":1,"referring_pages":13,"referring_links_tld":{"ly":13},"referring_links_types":{"redirect":13},"referring_links_attributes":null,"referring_links_platform_types":null,"referring_links_semantic_locations":{"":13}}},{"1":{"type":"backlinks_domain_intersection","target":"www.vpnnologs.com","rank":285,"backlinks":15,"first_seen":"2019-07-21 06:25:58 +00:00","lost_date":null,"broken_backlinks":0,"broken_pages":0,"referring_domains":1,"referring_main_domains":1,"referring_ips":1,"referring_subnets":1,"referring_pages":15,"referring_links_tld":{"com":15},"referring_links_types":{"anchor":15},"referring_links_attributes":null,"referring_links_platform_types":{"unknown":15},"referring_links_semantic_locations":{"section":15}},"2":{"type":"backlinks_domain_intersection","target":"www.vpnnologs.com","rank":284,"backlinks":11,"first_seen":"2019-07-21 06:25:58 +00:00","lost_date":null,"broken_backlinks":0,"broken_pages":0,"referring_domains":1,"referring_main_domains":1,"referring_ips":1,"referring_subnets":1,"referring_pages":11,"referring_links_tld":{"com":11},"referring_links_types":{"anchor":11},"referring_links_attributes":null,"referring_links_platform_types":{"unknown":11},"referring_links_semantic_locations":{"section":11}}},{"1":{"type":"backlinks_domain_intersection","target":"www.asiabet8888.com","rank":252,"backlinks":1,"first_seen":"2020-01-24 20:26:27 +00:00","lost_date":null,"broken_backlinks":0,"broken_pages":0,"referring_domains":1,"referring_main_domains":1,"referring_ips":1,"referring_subnets":1,"referring_pages":1,"referring_links_tld":{"com":1},"referring_links_types":{"anchor":1},"referring_links_attributes":null,"referring_links_platform_types":{"unknown":1},"referring_links_semantic_locations":{"article":1}},"2":{"type":"backlinks_domain_intersection","target":"www.asiabet8888.com","rank":252,"backlinks":1,"first_seen":"2020-01-24 20:26:27 +00:00","lost_date":null,"broken_backlinks":0,"broken_pages":0,"referring_domains":1,"referring_main_domains":1,"referring_ips":1,"referring_subnets":1,"referring_pages":1,"referring_links_tld":{"com":1},"referring_links_types":{"anchor":1},"referring_links_attributes":null,"referring_links_platform_types":{"unknown":1},"referring_links_semantic_locations":{"article":1}}},{"1":{"type":"backlinks_domain_intersection","target":"www.whatismyanipaddress.com","rank":246,"backlinks":2,"first_seen":"2021-09-09 04:02:07 +00:00","lost_date":null,"broken_backlinks":0,"broken_pages":0,"referring_domains":1,"referring_main_domains":1,"referring_ips":1,"referring_subnets":1,"referring_pages":2,"referring_links_tld":{"com":2},"referring_links_types":{"anchor":2},"referring_links_attributes":null,"referring_links_platform_types":{"blogs":2,"cms":2},"referring_links_semantic_locations":{"article":2}},"2":{"type":"backlinks_domain_intersection","target":"www.whatismyanipaddress.com","rank":246,"backlinks":2,"first_seen":"2021-09-09 04:02:07 +00:00","lost_date":null,"broken_backlinks":0,"broken_pages":0,"referring_domains":1,"referring_main_domains":1,"referring_ips":1,"referring_subnets":1,"referring_pages":2,"referring_links_tld":{"com":2},"referring_links_types":{"anchor":2},"referring_links_attributes":null,"referring_links_platform_types":{"blogs":2,"cms":2},"referring_links_semantic_locations":{"article":2}}},{"1":{"type":"backlinks_domain_intersection","target":"www.bestvpnaustralia.com.au","rank":226,"backlinks":1172,"first_seen":"2020-08-08 14:00:31 +00:00","lost_date":null,"broken_backlinks":0,"broken_pages":0,"referring_domains":1,"referring_main_domains":1,"referring_ips":2,"referring_subnets":2,"referring_pages":261,"referring_links_tld":{"com.au":261},"referring_links_types":{"anchor":261},"referring_links_attributes":null,"referring_links_platform_types":{"blogs":261,"cms":261},"referring_links_semantic_locations":{"":261}},"2":{"type":"backlinks_domain_intersection","target":"www.bestvpnaustralia.com.au","rank":173,"backlinks":395,"first_seen":"2019-07-17 07:07:07 +00:00","lost_date":null,"broken_backlinks":0,"broken_pages":0,"referring_domains":1,"referring_main_domains":1,"referring_ips":2,"referring_subnets":2,"referring_pages":198,"referring_links_tld":{"com.au":198},"referring_links_types":{"anchor":197,"redirect":1},"referring_links_attributes":{"noopener":197,"noreferrer":197},"referring_links_platform_types":{"blogs":197,"cms":197},"referring_links_semantic_locations":{"":198}}},{"1":{"type":"backlinks_domain_intersection","target":"torrentfreak.com","rank":224,"backlinks":27669,"first_seen":"2019-01-17 00:08:52 +00:00","lost_date":null,"broken_backlinks":0,"broken_pages":0,"referring_domains":1,"referring_main_domains":1,"referring_ips":3,"referring_subnets":3,"referring_pages":13846,"referring_links_tld":{"com":13846},"referring_links_types":{"anchor":13846},"referring_links_attributes":{"nofollow":13616,"sponsored":13616,"noopener":13},"referring_links_platform_types":{"blogs":13846,"cms":13846},"referring_links_semantic_locations":{"section":13618,"aside":204,"article":24}},"2":{"type":"backlinks_domain_intersection","target":"torrentfreak.com","rank":140,"backlinks":13,"first_seen":"2019-01-19 17:18:25 +00:00","lost_date":null,"broken_backlinks":0,"broken_pages":0,"referring_domains":1,"referring_main_domains":1,"referring_ips":3,"referring_subnets":3,"referring_pages":13,"referring_links_tld":{"com":13},"referring_links_types":{"anchor":13},"referring_links_attributes":null,"referring_links_platform_types":{"blogs":13,"cms":13},"referring_links_semantic_locations":{"article":13}}},{"1":{"type":"backlinks_domain_intersection","target":"pckeepclean.com","rank":223,"backlinks":9,"first_seen":"2021-08-27 14:51:04 +00:00","lost_date":null,"broken_backlinks":0,"broken_pages":0,"referring_domains":1,"referring_main_domains":1,"referring_ips":1,"referring_subnets":1,"referring_pages":3,"referring_links_tld":{"com":3},"referring_links_types":{"anchor":2,"redirect":1},"referring_links_attributes":null,"referring_links_platform_types":{"blogs":2,"cms":2},"referring_links_semantic_locations":{"article":2,"":1}},"2":{"type":"backlinks_domain_intersection","target":"pckeepclean.com","rank":0,"backlinks":1,"first_seen":"2021-09-27 20:22:07 +00:00","lost_date":null,"broken_backlinks":0,"broken_pages":0,"referring_domains":1,"referring_main_domains":1,"referring_ips":1,"referring_subnets":1,"referring_pages":1,"referring_links_tld":{"com":1},"referring_links_types":{"redirect":1},"referring_links_attributes":null,"referring_links_platform_types":null,"referring_links_semantic_locations":{"":1}}}]}]}]}';
            $this->result = json_decode($result, true);

            $this->printConsole();


//            ob_start();
//            var_dump(json_encode($this->result));
//            $text = ob_get_clean();
//            $fp = fopen("lll.txt", "a+");
//            fwrite($fp, $text);
//            fclose($fp);

        } catch (\RestClientException $e) {
            echo PHP_EOL;
            echo "HTTP code: ".$e->getHttpCode().PHP_EOL;
            echo "Error code: ".$e->getCode().PHP_EOL;
            echo "Message: ".$e->getMessage().PHP_EOL;
            echo PHP_EOL;
        }

    }

    /**
     * print table in console
     */
    private function printConsole(){


        $out = PHP_EOL;

        $out .= 'status_code = '.( $this->result['tasks'][0]['status_code'] ?? 'unknown' ).PHP_EOL;
        $out .= 'status_message = '.( $this->result['tasks'][0]['status_message'] ?? 'unknown' ).PHP_EOL;

        $out .= $this->printDivider('=');

        // table header
        $out .= '     excluded_target          |';
        $out .= '       target_domain          |';
        $out .= '       referring_domain       |';
        $out .= ' rank  |';
        $out .= '          first_seen          |';
        $out .= '          lost_date           |';
        $out .= PHP_EOL;

        $out .= $this->printDivider('=');

        $dbLogs = [];
        $date = date('Y-m-d H:i:s');
        foreach ($this->result['tasks'][0]['result'][0]['items'] as $items){
            foreach ($items as $key => $item){

                $log = [];
                foreach (self::configTable as $col=>$lengh){
                    switch ($col){
                        case 'excluded_target':
                            $text = '';
                            if($this->excludeTargets){
                                $text = $this->excludeTargets;
                            }
                            $log['excluded_target'] = $text;
                            $out .= $this->printColum($text, $lengh);
                            break;
                        case 'target_domain':
                            $text = $this->domainsClient[$key] ?? '';
                            $log['target_domain'] = $text;
                            $out .= $this->printColum($text, $lengh);
                            break;
                        case 'referring_domain':
                            $text = $item['target'] ?? '';
                            $log['referring_domain'] = $text;
                            $out .= $this->printColum($text, $lengh);
                            break;
                        case 'rank':
                            $text = (string)( $item['rank'] ?? '');
                            $log['rank'] = $text;
                            $out .= $this->printColum($text, $lengh);
                            break;
                        case 'first_seen':
                        case 'lost_date':
                            $text = $item[$col] ?? '';
                            $out .= $this->printColum($text, $lengh);
                            break;
                    }
                }
                $log['created_at'] = $date;
                $log['updated_at'] = $date;
                $dbLogs[] = $log;

                $out .= PHP_EOL;
                $out .= $this->printDivider('-');
            }
        }

        DB::table(self::LOG_TABLE)->insert($dbLogs);

        echo $out;
    }

    /**
     * @param string $text
     * @param int $lengh
     * @return string
     */
    private function printColum(string $text, int $lengh){
        $out = ' '.$text;
        $i = strlen($text)+1;
        for ($i; $i<$lengh; $i++){
            $out .= ' ';
        }
        $out .= '|';

        return $out;
    }

    /**
     * @param string $type
     * @return string
     */
    private function printDivider($type = '-'){
        $out = '';
        for ($i=0; $i<self::lenghTable; $i++){
            $out .= $type;
        }
        $out .= PHP_EOL;
        return $out;
    }

}
