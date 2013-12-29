<?
class md5 {

    function gri($iv_len)
    {
        $iv = '';
        while ($iv_len-- > 0) {
            $iv .= chr(mt_rand() & 0xff);
        }
        return $iv;
    }
    /**
     * codifica
     */
    function code($plain_text, $password = "", $iv_len = 16) 
	{
        //if ($plain_text == "") die("Sem texto");
        $plain_text .= "x13";
        $n = strlen($plain_text);
        if ($n % 16) $plain_text .= str_repeat("{TEXTO}", 16 - ($n % 16));
        $i = 0;
        $enc_text = $this->gri($iv_len);
        $iv = substr($password ^ $enc_text, 0, 512);
        while ($i < $n) {
            $block = substr($plain_text, $i, 16) ^ pack('H*', md5($iv));
            $enc_text .= $block;
            $iv = substr($block . $iv, 0, 512) ^ $password;
            $i += 16;
        }

        return strtr(base64_encode($enc_text),"+/","-_");

    }
    /**
     * decodifica
     */
    function decode($enc_text, $password = "", $iv_len = 16) 
	{
        //if ($enc_text == "") die("Sem texto");
        $enc_text = base64_decode(strtr($enc_text,"-_","+/"));
        $n = strlen($enc_text);
        $i = $iv_len;
        $plain_text = '';
        $iv = substr($password ^ substr($enc_text, 0, $iv_len), 0, 512);
        while ($i < $n) {
            $block = substr($enc_text, $i, 16);
            $plain_text .= $block ^ pack('H*', md5($iv));
            $iv = substr($block . $iv, 0, 512) ^ $password;
            $i += 16;
        }
        $pos = strrpos($plain_text,"x13");
        return substr($plain_text,0,$pos);
    }
}
?>