<?php

class CustomDateTimeClass
{
	public $timezone;
	public $format;
	public $time;

	public function getTime()
	{
		$this->timezone = (isset($this->timezone) && !empty($this->timezone)) ? $this->timezone : "UTC";
		$this->format = (isset($this->format) && !empty($this->format)) ? $this->format : "U";
		$this->time = (isset($this->time) && !empty($this->time)) ? $this->time : time();

		$dt = new DateTime("now", new DateTimeZone($this->timezone));
	$dt->setTimestamp((int)$this->time);

		return $dt->format($this->format);
		unset($dt);
	}
}

$customDateTime = new CustomDateTimeClass;
$customDateTime->timezone = "Europe/Istanbul";
$customDateTime->format = "d.m.Y H.i.s";
$customDateTime->time = time();
echo $customDateTime->getTime();
unset($customDateTime);

/**
* Bu sınıf php (ini) zaman dilimini güncellemeden istediğiniz zaman dilimi için istediğiniz zamana ait zamanı istediğiniz formatta almanızı sağlıyor.
* Böylece sunucu çapında küresel bir ayara müdahale etmeden istediğiniz zaman bilgisine ulaşmış oluyorsunuz.
* Bu yazılım nerelerde kullanılabilir? : Belirli bir zaman dilimi için zaman bilgisi almanız gerek ve sunucu zaman diliminin değiştirilmemesi de gerekiyor.
* Mesela ödeme hizmetlerinde sunucu zaman dilimi kayıtlama (log) sabit olması ve degiştirilmemesi gerekir ki takibi doğru yapılabilsin.
* Sunucu zaman dilimi UTC olduğunu varsayalım. İşlem kayıtları UTC zaman dilimine göre kaydediliyor.
* Ancak sizin zamanı ekrana "Europe/Istanbul" zaman diliminde göstermeniz gerekiyor.
* Bu durumda php ini_set fonksiyonu ile zaman dilimini güncellerseniz daha ilgili php işlemi tamamlanana kadar ya da yeni bir zaman dilimi belirlenene kadar tüm zaman bilgisi yeni zaman dilimine göre işleneceği için kayıtlarınızda zaman kaymasına neden olacaktır.
* İşte bu durumda küresel php zaman dilimini güncellemek yerine istediğiniz bir zaman dilimi için ilgili zamanın karşılığını almak daha uygundur.

Kullanım;
24. satırdan zaman dilimi tanımlanır. Varsayılan: "UTC". *Zorunlu değil.
25. satırdan almak istediğiniz verilerin formatı tanımlanır. Varsayılan: "U" (Unix Zaman Dilimi). *Zorunlu değil.
26. satırdan zaman tanımlanır. İşlem anındaki o an için zaman bilgisi alınmak isteniyorsa standart time() fonksiyonu kullanılabilir. İsterseniz geçmiş ya da gelecek zaman tanımlanabilir. Unix zaman birimi olarak girilmelidir. Varsayılan: time(). *Zorunlu değil.
*/

?>