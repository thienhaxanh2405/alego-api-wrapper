<?php
namespace AlegoApiWrapper\Message;

class Message
{
    const SUCCESS = 1;
    const CALL_API_WITH_ERROR = 2;
    const ALEGO_RESPONSE_WITH_ERROR = 3;
    const INVALID_JSON = 4;
    const MISSING_PARAMS = 5;

    public static $message = [
        self::SUCCESS => "Thành công",
        self::CALL_API_WITH_ERROR => "Lỗi khi gọi API",
        self::ALEGO_RESPONSE_WITH_ERROR => "Alego trả về lỗi",
        self::INVALID_JSON => "Json không chính xác",
        self::MISSING_PARAMS => "Thiếu tham số truyền vào",
    ];

    public static $alegoMessage = [
        '00' => 'Giao dịch thành công',
        '01' => 'Hàm xử lý giao dịch không tồn tại',
        '02' => 'Version của hàm xử lý giao dịch không đúng',
        '03' => 'Mã đại lý hoặc tài khoản đại lý không tồn tại',
        '04' => 'Đại lý đang bị khoá hoặc bị phong toả tài khoản',
        '05' => 'Số dư đại lý không đủ để thực hiện giao dịch',
        '06' => 'Mã checksum không chính xác',
        '07' => 'Dữ liệu mã hoá không chính xác (không giải mã được)',
        '08' => 'IP của đại lý không được phép kết nối',
        '09' => 'Mã dịch vụ không tồn tại hoặc tài khoản của đại lý không được cấu hình để được mua dịch vụ này',
        '10' => 'Dịch vụ đang tạm dừng do Alego tạm dừng cung cấp dịch vụ hoặc lỗi kết nối từ Alego tới nhà cung cấp nên bị tạm dừng.',
        '11' => 'Mã đơn hàng do đại lý gửi tới Alego đã tồn tại, không được phép trùng lặp (do đã tồn tại trong một giao dịch trước đó)',
        '12' => 'Mệnh giá thẻ không đúng với dịch vụ cung cấp (ví dụ thẻ cào Telco không có mệnh giá 40,000đ).',
        '13' => 'Số lượng thẻ yêu cầu bán không phù hợp (không đúng) với dịch vụ. Ví dụ, thẻ visa ảo Alego chỉ cho phép mỗi lần bán 01 thẻ trong một giao dịch nhưng đại lý truyền sang cần mua 02 thẻ trong giao dịch',
        '14' => 'Định dạng dữ liệu khác trong giao dịch không hợp lệ (thiếu tham số hoặc giá trị của tham số không đúng. Ví dụ định dạng – format của email không đúng, thiếu số điện thoại của người mua,...)',
        '15' => 'Lỗi từ nhà cung cấp dịch vụ (dẫn đến lỗi kết nối từ Alego tới nhà cung cấp dịch vụ), giao dịch tạm thời không thể xử lý',
        '16' => 'Số lượng thẻ của Alego không đủ theo số lượng yêu cầu mua của đại lý',
        '17' => 'Tài khoản hoặc thuê bao nạp tiền không chính xác, giao dịch thất bại',
        '18' => 'Tài khoản hoặc thuê bao đang bị khóa, giao dịch thất bại',
        '97' => 'Kênh hiện chưa được khai báo vui lòng liên hệ Alego hỗ trợ',
        '98' => 'Kết nối theo yêu cầ u không tồ n tại hoặc chưa được khai báo',
        '99' => 'Lỗi không xác định',
    ];

    public static function getMessage($code)
    {
        if(isset(self::$message[$code])) {
            return self::$message[$code];
        } else {
            return "Mã thông báo không tồn tại";
        }
    } // end get message

    public static function getAlegoMessage($code)
    {
        if(isset(self::$alegoMessage[$code])) {
            return self::$alegoMessage[$code];
        } else {
            return "Mã thông báo không tồn tại";
        }
    } // end get alego message

} // end class
