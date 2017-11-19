<?php

function encryptData($input, $key_seed = "1234567890123") {
    $input = trim($input);
    $block = mcrypt_get_block_size('tripledes', 'ecb');
    $len = strlen($input);
    $padding = $block - ($len % $block);
    $input .= str_repeat(chr($padding), $padding);

    // generate a 24 byte key from the md5 of the seed 		 
    $key = substr(md5($key_seed), 0, 24);
    $iv_size = mcrypt_get_iv_size(MCRYPT_TRIPLEDES, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

    // encrypt 		 
    $encrypted_data = mcrypt_encrypt(MCRYPT_TRIPLEDES, $key, $input, MCRYPT_MODE_ECB, $iv);
    // clean up output and return base64 encoded 
    $encrypted_data = base64_encode($encrypted_data);
    return $encrypted_data;
}

function decrypt($input, $key_seed = "1234567890123") {
    $input = base64_decode($input);
    $key = substr(md5($key_seed), 0, 24);

    $text = mcrypt_decrypt(MCRYPT_TRIPLEDES, $key, $input, MCRYPT_MODE_ECB, 'Mkd34ajdfka5');
    $block = mcrypt_get_block_size('tripledes', 'ecb');
    $packing = ord($text{strlen($text) - 1});

    if ($packing and ( $packing < $block)) {
        for ($P = strlen($text) - 1; $P >= strlen($text) - $packing; $P--) {
            if (ord($text{$P}) != $packing) {
                $packing = 0;
            }
        }
    }

    $text = substr($text, 0, strlen($text) - $packing);
    return $text;
}

//Hàm gọi sáng Alego
function postUrl($url, $data) {
    //Định nghĩa Header khi gọi
    $headerArray = array(
        'Content-Type: application/json; charset=UTF-8',
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArray);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);

    $result = curl_exec($ch);
    $result = json_decode($result, true);

    return $result;
}

function dataCard() {
//ID tài khoản của đại lý
    $AccID = "571a01a0e4b0b96b6f950ad5";
//Mã dịch vụ, sản phẩm
    $ProductCode = 300;
    $CardNumber = 1;
//Mã tham chiếu đại lý gửi sang (mã này là duy nhất trong mỗi lần gửi sang)
    $RefNumber = "DL" . time() . rand(1000, 9999);


//Mảng dữ liệu thông tin đơn hàng
    $data = array(
        //Ma sản phẩm
        'ProductCode' => $ProductCode,
        //Mã tham chiếu đại lý gửi sang
        'RefNumber' => $RefNumber,
        //Địa chỉ IP của đại lý
        'CustIP' => "127.0.0.1",
        //Mệnh giá thẻ mua
        'CardPrice' => 10000,
        //Số lượng thẻ mua
        'CardQuantity' => $CardNumber,
    );
    var_dump($data);
//Key tạo checksum cap cho dai ly
    $connectKey = 'adrMjEJArHysrhwM';
//Tạo string json
    $data = json_encode($data);
//Mã hóa String data
    $EncData = encryptData($data);
//Hàm thực hiện mua dữ liệu
    $Func = "buyPrepaidCards";
    $ver = '1.0';
    $agentId = 1;

//Tạo mã checksum, chữ ký
    $CheckSum = md5($Func . $ver . $agentId . $AccID . $EncData . $connectKey);

//Khởi tạo mảng dữ liệu gọi sang Alego
    $inputs = array(
        'Fnc' => $Func,
        'Ver' => $ver,
        'AgentID' => $agentId,
        'AccID' => $AccID,
        'EncData' => $EncData,
        'Checksum' => $CheckSum,
    );

//Thực hiện tạo String json mảng
    echo $inputs = json_encode($inputs);

    return $inputs;
}

//URL API service Alego
$url = "http://dev.alego.vn:8888/agent_api/";
set_time_limit(0);
//Hàm thực hiện phương thức post
$data = postUrl($url, dataCard());

echo 'Data Reponse encode: ';
var_dump($data);
echo '<br />';

$encodeData = $data['EncData'];
$desData = decrypt($encodeData);

echo 'Data Reponse decode: ';
var_dump($desData);
var_dump(json_decode($desData),true);
echo '<hr />';
?>