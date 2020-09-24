<?php

class LicenseClass
{
	public $http_status_code = 503;
	public $domain;
	public $ip;

	private function return_error($message)
	{
		if (isset($this->http_status_code) && !empty(trim($this->http_status_code)))
			http_response_code($this->http_status_code);
		exit($message);
		unset($message);
	}

	private function license_domain()
	{
		$lic_domain = $this->domain;

		if (!isset($_SERVER["SERVER_NAME"]))
		{
			unset($lic_domain);
			$this->return_error("Domain is not found. The file " . __FILE__ . " is protected by Aponkral.Dev");
		}

		$current_domain = (substr($_SERVER["SERVER_NAME"], 0, 4) === "www.") ? substr($_SERVER["SERVER_NAME"], 4) : $_SERVER["SERVER_NAME"];

		if($current_domain !== $lic_domain) {
			unset($lic_domain, $current_domain);
			$this->return_error("Domain is not licensed. The file " . __FILE__ . " is protected by Aponkral.Dev.");
		}
		else
			unset($lic_domain, $current_domain);
	}

	private function license_ip()
	{
		$lic_ip = $this->ip;

		if (!isset($_SERVER["SERVER_ADDR"]))
		{
			unset($lic_ip);
			$this->return_error("IP address is not found. The file " . __FILE__ . " is protected by Aponkral.Dev");
		}

		if($_SERVER["SERVER_ADDR"] !== $lic_ip) {
			unset($lic_ip);
			$this->return_error("IP address is not licensed. The file " . __FILE__ . " is protected by Aponkral.Dev.");
		}
		else
			unset($lic_ip);
	}

	public function check()
	{
		if (isset($this->domain) && !empty(trim($this->domain)))
			$this->license_domain();
		if (isset($this->ip) && !empty(trim($this->ip)))
			$this->license_ip();
	}
}

/**
* Hata mesajı oluşması durumunda http başlığında kullanılacak durum kodunu 78. satırdaki $license->http_status_code değişkeninden tanımlayabilirsiniz. *Opsiyonel. Tanımlanması zorunlu değildir.
* Alan adını 79. satırdaki $license->domain değişkeninden tanımlayabilirsiniz. *Opsiyonel. Tanımlanması zorunlu değildir.
* Lisanslanan alan adının www alt alan adı da lisanslanmış olur.
* Sadece bir adet alan adı lisanslanabilir.
* IP adresini 80. satırdaki $license->ip değişkeninden tanımlayabilirsiniz. *Opsiyonel. Tanımlanması zorunlu değildir.
* Sadece bir adet ip adresi lisanslanabilir.
* Lisans kontrolü için LicanseClass sınıfı çağrılarak LicanseClass::check() ($license->check()) fonksiyonu yazılımınızın kodlarından önce çağrılır.
* LicenseClass eğer alan adı lisanslaması varsa geçerli alan adı ile lisanslanan alan adını, eğer ip adresi lisanslaması varsa geçerli sunucu ip adresi ile lisanslanan ip adresini karşılaştıracaktır.
* Eğer uyuşmazlık varsa LicenseClass hata mesajıyla birlikte çalışmayı durdurur.
* Eğer uyuşmazlık yoksa LicenseClass çalışmayı devam ettirecektir.
*/

$license = new LicenseClass;
$license->http_status_code = 503;
$license->domain = "aponkral.com";
// $license->ip = "127.0.0.1";
$license->check();
unset($license);

// Lisans kontrolü tamamlanmıştır. Yazılım kodlarınızı 84. (dahil) satırdan itibaren yürütülür.
echo "Lala";

?>