# Alego Api Wrapper
Wrapper này mình viết để tiện cho việc gọi API sang hệ thống Alego.

## Tác giả
thienhaxanh2405 <nguyenductoan2405@gmail.com>

http://thienhaxanh.info

## Yêu cầu
* PHP từ 5.4 đến 7.0 (Trong version tiếp theo của wrapper này sẽ cập nhật để hỗ trợ PHP 7.1 trở lên)
* Mcrypt (http://php.net/manual/en/book.mcrypt.php)

## Cài đặt
Qua composer: 
`composer require thienhaxanh2405/alego-api-wrapper`

Để sử dụng
`require_once "/path/to/vendor/autoload.php";`

## Đối tượng (Object)
- **\AlegoApiWrapper\Resource\Buy** Đối tượng truyền tham số cho các giao dịch. Phụ thuộc vào từng giao dịch, các tham số cần truyền vào có thể khác nhau.
- **\AlegoApiWrapper\Resource\ApiResponse** Đối tượng chứa các thông tin trả về cho mỗi giao dịch bao gồm:
    - **message**: thông báo của giao dịch.
    - **messageCode**: mã thông báo.
    - **rawData**: dữ liệu thô được trả về từ API.
    - **result**: đối tượng chứa thông tin trả về sau khi đã được xử lý từ rawData. Có thể là **_\AlegoApiWrapper\Resource\CardResult_** hoặc **_\AlegoApiWrapper\Resource\Balance_** tùy thuộc vào giao dịch hiện tại.
- **\AlegoApiWrapper\Resource\CardResult**: Chứa thông tin trả về khi mua thẻ điện thoại/topup/thẻ game/visa trả trước/kiểm tra giao dịch.
    - **productCode**: mã dịch vụ của Alego.
    - **$referOrder**: mã tham chiếu giao dịch trên hệ thống của bạn
    - **alegoTransactionId**: id của giao dịch tương ứng trên hệ thống Alego
    - **time**: thời gian giao dịch trên hệ thống Alego, định dạng unix timestamp.
    - **responseType**: Alego trả về kết quả thông qua: 1 - email; 2 - trực tiếp trong API. 
    - **cardQuantity**: số lượng thẻ.
    - **cards**: mảng chứa thông tin thẻ hoặc mảng rỗng. Mỗi phần tử của mảng là một đối tượng **_\AlegoApiWrapper\Resource\PrepaidCard_** hoặc Visa card trong tương lai khi wrapper hỗ trợ mua thẻ Visa trả trước.
- **\AlegoApiWrapper\Resource\Balance**: Chứa thông tin số dư tài khoản đại lý.
    - **balance**: Tổng số dư.
    - **availableBalance**: Số dư khả dụng.
    - **frozenBalance**: Số dư bị đóng băng.
- **\AlegoApiWrapper\Resource\PrepaidCard**: chứa thông tin thẻ cào địa thoại. Bao gồm:
    - **code**: mã nạp thẻ.
    - **serial**: seri thẻ.
    - **expirationDate**: ngày hết hạn thẻ.
    
## Hằng khai báo sẵn (Constant)
- **\AlegoApiWrapper\Constant\AlegoProduct**: Mã sản phẩm/dịch vụ tương ứng trên hệ thống Alego.
- **\AlegoApiWrapper\Constant\Telco**: Nhà mạng/mã nhà mạng di động.
- **\AlegoApiWrapper\Constant\PrepaidCardPrice**: mệnh giá thẻ cào điện thoại.
- **\AlegoApiWrapper\Constant\AlegoTransactionType**: Loại giao dịch trên hệ thống Alego.

## Thông tin kết nối
1. Bạn cần đăng ký tài khoản đại lý tại http://alego.vn. 
Sử dụng thông tin kết nối để khởi tạo đối tượng Account.

```
use AlegoApiWrapper\Connection\Account;

// thông tin account bên dưới là tài khoản test của Alego
// thay thế bằng thông tin tài khoản của bạn
$account = new Account(
         [
             'agentId' => 1,
             'accountId' => '571a01a0e4b0b96b6f950ad5',
             'keyMD5' => 'adrMjEJArHysrhwM',
             'tripleKey' => 'asdf'
         ]
     );
 ```
2. Khởi tạo đối tượng Client để thực hiện các giao dịch
```

use AlegoApiWrapper\Client;

$client = Client::createClient($account);
// trong trường hợp bạn muốn chạy trên môi trường Development, 
// bạn có thể thêm 2 tham số vào hàm sau $account cho hàm createClient
// $isDevelopment = true và $debug = 1
// $client = Client::createClient($account, true, 1);

```

## Sử dụng
### Mua thẻ cào điện thoại
Khởi tạo một đối tượng \AlegoApiWrapper\Resource\Buy, cần tối thiểu các tham số:
- **referOrder**: mã tham chiếu trên hệ thống của bạn, có thể là id hoặc một mã đơn hàng **_duy nhất_** trên hệ thống của bạn tương ứng với giao dịch này.
- **productCode**: mã sản phẩm dịch vủa Alego tương ứng với giao dịch mua thẻ cào. Đã được định nghĩa sẵn các hằng số trong **_AlegoApiWrapper\Constant\AlegoProduct_** để bạn có thể dễ dàng gọi và sử dụng.
- **telco**:  mã nhà mạng. Đã được định nghĩa sẵn trong **_AlegoApiWrapper\Constant\Telco_**.
- **cardPrice**: mệnh giá thẻ cào. Đã được định nghĩa sẵn trong **_AlegoApiWrapper\Constant\PrepaidCardPrice_**.
- **cardQuantity**: số lượng thẻ cần mua (số nguyên)

Ví dụ mua 01 thẻ Viettel mệnh giá 100 000đ.
```

use AlegoApiWrapper\Constant\AlegoProduct;
use AlegoApiWrapper\Constant\Telco;
use AlegoApiWrapper\Constant\AlegoTransactionType;
use AlegoApiWrapper\Resource\Buy;
use AlegoApiWrapper\Constant\PrepaidCardPrice;

$buyCard = new Buy(
   [
       'referOrder' => uniqid(),
       'productCode' => \AlegoApiWrapper\Constant\AlegoProduct::PREPAID_CARD_VIETTEL,
       'telco' => \AlegoApiWrapper\Constant\Telco::VIETTEL_CODE,
       'cardPrice' => \AlegoApiWrapper\Constant\PrepaidCardPrice::C_100,
       'cardQuantity' => 1
   ]
);

$res = $client->buyPrepaidCard($buyCard);

```
### Nạp tiền điện thoại
Khởi tạo một đối tượng \AlegoApiWrapper\Resource\Buy, cần tối thiểu các tham số:
- **referOrder**: mã tham chiếu trên hệ thống của bạn, có thể là id hoặc một mã đơn hàng **_duy nhất_** trên hệ thống của bạn tương ứng với giao dịch này.
- **productCode**: mã sản phẩm dịch vủa Alego tương ứng với giao dịch mua thẻ cào. Đã được định nghĩa sẵn các hằng số trong **_AlegoApiWrapper\Constant\AlegoProduct_** để bạn có thể dễ dàng gọi và sử dụng.
- **telco**:  mã nhà mạng. Đã được định nghĩa sẵn trong **_AlegoApiWrapper\Constant\Telco_**.
- **cardPrice**: mệnh giá thẻ cào. Đã được định nghĩa sẵn trong **_AlegoApiWrapper\Constant\PrepaidCardPrice_**.
- **customerCellphone**: số điện thoại được nạp tiền
- **type**: loại giao dịch trên hệ thống Alego. Nạp tiền cho thuê bao trả trước: **_AlegoTransactionType::TOPUP_PREPAID_** hoặc Nạp tiền cho thuê bao trả sau: **_AlegoTransactionType::TOPUP_POSTPAID_**

Ví dụ nạp tiền cho thuê bao: 0987802175 của nhà mạng Viettel số tiền 100 000đ.
```
use AlegoApiWrapper\Constant\AlegoProduct;
use AlegoApiWrapper\Constant\Telco;
use AlegoApiWrapper\Constant\AlegoTransactionType;
use AlegoApiWrapper\Resource\Buy;
use AlegoApiWrapper\Constant\PrepaidCardPrice;

$buy = new \AlegoApiWrapper\Resource\BuyPrepaidCard(
   [
       'referOrder' => uniqid(),
       'productCode' => \AlegoApiWrapper\Constant\AlegoProduct::TOPUP_PREPAID_VIETTEL,
       'telco' => \AlegoApiWrapper\Constant\Telco::VIETTEL_CODE,
       'cardPrice' => \AlegoApiWrapper\Constant\PrepaidCardPrice::C_100,
       'customerCellphone' => "0987802175"
   ]
);

$res = $client->prepaidTopUp($buy);

```
### Mua mã thẻ Game
Cập nhật trong thời gian tới

### Mua thẻ Visa trả trước
Cập nhật trong thời gian tới

### Mua thẻ Battle Net
Cập nhật trong thời gian tới

### Kiểm tra giao dịch
Sử dụng mã referOrder trên hệ thống của bạn để tham chiếu tới giao dịch trên hệ thống Alego.

Ví dụ bạn kiểm tra có mã trên hệ thống của bạn là: **_5a119e3c6cfb0_**

```
$res = $client->checkOrder("5a119e3c6cfb0");
```

### Kiểm tra số dư tài khoản
```
$res = $client->getBalance();
```

## Tests
Test case sẽ được bổ sung trong thời gian tới

## Hỗ trợ - giải đáp thắc mắc
Wrapper vẫn còn nhiều thiếu sót hoặc bug mà mình chưa tìm ra, các bạn vui lòng tạo issue hoặc liên hệ mình qua email: nguyenductoan2405@gmail.com. 


## License
Mình viết Wrapper này để phục vụ mục đích công việc cá nhân, tuy nhiên mình cũng không ngần ngại việc công khai và chia sẻ source này. Rất mong wrapper này sẽ có một chút hữu ích nào đó cho công việc của các bạn.

Mọi việc chia sẻ, góp ý, phân phối lại source này vui lòng theo giấy phép MIT.

_Trường hợp các bạn cứ thế lấy và sử dụng, cho vào project.... mà không theo giấy phép MIT thì mình cũng vẫn chào đón nhé =))_