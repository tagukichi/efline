<?php
/**
 * 取扱いクリニック初期データ（クライアント提供 Excel 2026-10-07 版より生成）。
 * inc/clinic-seed.php から読み込まれ、clinic CPT として一括登録される。
 *
 * - Excel の URL 列は医院名と行が一致していなかったため、official_url は各 URL を
 *   公的記録（厚労省 医療情報ネット）や公式サイトの住所・電話と突き合わせて医院を特定したもの。
 *   15 件すべて確認済み（2026-10-09）。URL の無い 6 件は Excel の「許可未入手」「なし」に相当。
 * - 凌雲堂矯正歯科医院の電話は Excel の「0534-56-7123」を「053-456-7123」に訂正
 *   （浜松の市外局番は 053。数字は同一）。
 *
 * @package efline
 */

if ( ! defined( "ABSPATH" ) ) {
	exit;
}

return array (
  0 => 
  array (
    'seed' => 1,
    'name' => '文野矯正歯科',
    'postal_code' => '104-0061',
    'address' => '東京都 中央区 銀座 ４－３－１０ モトキＮビル ３Ｆ',
    'phone' => '03-3538-2113',
    'official_url' => 'https://www.fumino.net/',
    'area' => '東京都中央区',
  ),
  1 => 
  array (
    'seed' => 2,
    'name' => 'さっぽろ矯正歯科クリニック',
    'postal_code' => '062-0921',
    'address' => '北海道札幌市豊平区中の島一条3-7-11',
    'phone' => '011-833-4188',
    'official_url' => 'https://www.hanarabi418.com/',
    'area' => '北海道札幌市',
  ),
  2 => 
  array (
    'seed' => 3,
    'name' => '下北沢茶沢通り矯正歯科',
    'postal_code' => '155-0032',
    'address' => '東京都 世田谷区 代沢 5-19-13',
    'phone' => '03-6453-2919',
    'official_url' => 'https://ortho-tokyo.com/',
    'area' => '東京都世田谷区',
  ),
  3 => 
  array (
    'seed' => 4,
    'name' => '代沢デンタルクリニック',
    'postal_code' => '155-0032',
    'address' => '東京都世田谷区代沢1-3-5',
    'phone' => '03-5431-3182',
    'official_url' => 'https://www.daizawa-dc.com/',
    'area' => '東京都世田谷区',
  ),
  4 => 
  array (
    'seed' => 5,
    'name' => '整美会矯正歯科クリニック',
    'postal_code' => '160-0022',
    'address' => '東京都 新宿区 新宿 ３－１７－２　４Ｆ',
    'phone' => '03-3352-3357',
    'official_url' => 'https://www.seibikai.or.jp/',
    'area' => '東京都新宿区',
  ),
  5 => 
  array (
    'seed' => 6,
    'name' => '早稲田駅前歯科矯正歯科',
    'postal_code' => '162-0045',
    'address' => '東京都新宿区馬場下町63 西堀ビル1階',
    'phone' => '03-3232-6482',
    'official_url' => 'https://www.waseda-ekimae.com/',
    'area' => '東京都新宿区',
  ),
  6 => 
  array (
    'seed' => 7,
    'name' => '医)KOC 神楽坂矯正歯科クリニック',
    'postal_code' => '162-0825',
    'address' => '東京都 新宿区 神楽坂 5-30-2',
    'phone' => '03-5228-0122',
    'official_url' => '',
    'area' => '東京都新宿区',
  ),
  7 => 
  array (
    'seed' => 8,
    'name' => 'きむら矯正歯科',
    'postal_code' => '178-0063',
    'address' => '東京都 練馬区 東大泉 4丁目31-1 北園ﾒﾃﾞｨｶﾙﾓｰﾙ 1階',
    'phone' => '03-5935-8537',
    'official_url' => '',
    'area' => '東京都練馬区',
  ),
  8 => 
  array (
    'seed' => 9,
    'name' => '久米川Ｃｏｓｍｏｓ矯正歯科',
    'postal_code' => '189-0013',
    'address' => '東京都 東村山市 栄町 1-3-66 第三ｼｰﾏﾋﾞﾙ 2階',
    'phone' => '080-6609-6205',
    'official_url' => 'https://www.kumegawa-cosmos.com/',
    'area' => '東京都東村山市',
  ),
  9 => 
  array (
    'seed' => 10,
    'name' => 'エンゼル歯科クリニック',
    'postal_code' => '202-0015',
    'address' => '東京都 西東京市 保谷町 3-22-7',
    'phone' => '042-464-8744',
    'official_url' => '',
    'area' => '東京都西東京市',
  ),
  10 => 
  array (
    'seed' => 11,
    'name' => '千葉ニュータウン河合歯科矯正歯科',
    'postal_code' => '270-1350',
    'address' => '千葉県印西市中央北1-469 アルカサール２階',
    'phone' => '0476-40-0046',
    'official_url' => 'https://www.cn-kawai-dental.com/',
    'area' => '千葉県印西市',
  ),
  11 => 
  array (
    'seed' => 12,
    'name' => '東川口駅前歯科＆矯正歯科',
    'postal_code' => '333-0801',
    'address' => '埼玉県川口市東川口 2丁目1-1 2階',
    'phone' => '048-287-8113',
    'official_url' => '',
    'area' => '埼玉県川口市',
  ),
  12 => 
  array (
    'seed' => 13,
    'name' => 'ちとせ矯正歯科戸田',
    'postal_code' => '335-0021',
    'address' => '埼玉県戸田市新曽109番地1F',
    'phone' => '048-242-3447',
    'official_url' => 'https://chitose-ortho.com/',
    'area' => '埼玉県戸田市',
  ),
  13 => 
  array (
    'seed' => 14,
    'name' => 'こいずみ矯正歯科クリニック',
    'postal_code' => '340-0206',
    'address' => '埼玉県久喜市西大輪4-3-14',
    'phone' => '0480-59-4184',
    'official_url' => 'https://k-o-c.com/',
    'area' => '埼玉県久喜市',
  ),
  14 => 
  array (
    'seed' => 15,
    'name' => 'つのだ矯正',
    'postal_code' => '346-0003',
    'address' => '埼玉県 久喜市 中央 1-4-32',
    'phone' => '0480-26-1187',
    'official_url' => 'https://www.tsunoda-ortho.com/',
    'area' => '埼玉県久喜市',
  ),
  15 => 
  array (
    'seed' => 16,
    'name' => '三井病院歯科矯正',
    'postal_code' => '350-0066',
    'address' => '埼玉県 川越市 連雀町 １９－３',
    'phone' => '049-222-8236',
    'official_url' => 'https://mitsui-ortho.com/',
    'area' => '埼玉県川越市',
  ),
  16 => 
  array (
    'seed' => 17,
    'name' => '麻生デンタルクリニック',
    'postal_code' => '362-0001',
    'address' => '埼玉県上尾市上824-3',
    'phone' => '048-777-2568',
    'official_url' => '',
    'area' => '埼玉県上尾市',
  ),
  17 => 
  array (
    'seed' => 18,
    'name' => '近藤矯正歯科医院',
    'postal_code' => '420-0031',
    'address' => '静岡県 静岡市 葵区呉服町 2-6-10 ﾚｲｱｯﾌﾟ呉服町ﾋﾞﾙ 4Ｆ',
    'phone' => '054-251-5878',
    'official_url' => 'https://kondo-ortho.com/',
    'area' => '静岡県静岡市',
  ),
  18 => 
  array (
    'seed' => 19,
    'name' => '凌雲堂矯正歯科医院',
    'postal_code' => '430-0944',
    'address' => '静岡県浜松市中央区田町 ２２４－８ 三晃田町ビル ２Ｆ',
    'phone' => '053-456-7123',
    'official_url' => '',
    'area' => '静岡県浜松市',
  ),
  19 => 
  array (
    'seed' => 20,
    'name' => '石田歯科医院',
    'postal_code' => '713-8122',
    'address' => '岡山県倉敷市玉島中央町1-22-43',
    'phone' => '086-522-6480',
    'official_url' => 'http://www.ishida-dc.net/',
    'area' => '岡山県倉敷市',
  ),
  20 => 
  array (
    'seed' => 21,
    'name' => '石田歯科・矯正歯科クリニック',
    'postal_code' => '730-0013',
    'address' => '広島県広島市中区八丁堀4-4 ｴｲﾄﾊﾞﾚｰ八丁堀2F',
    'phone' => '082-223-1177',
    'official_url' => 'https://www.ishida-dental.jp/',
    'area' => '広島県広島市',
  ),
);
