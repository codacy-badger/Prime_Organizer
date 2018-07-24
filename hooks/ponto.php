<?php
    
    
        $CNPJ = $_REQUEST['cnpj'];
        
        $soap = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:stor="http://store.primews.com.br/">
                    <soapenv:Header/>
                    <soapenv:Body>
                        <stor:listEmployeeByCnpj>
                            <cnpj>'. $CNPJ .'</cnpj>
                        </stor:listEmployeeByCnpj>
                    </soapenv:Body>
                </soapenv:Envelope>';
        
        $curl = curl_init();
        
        $url = 'https://srep.primesw.com.br/primecontrol_gateway/storage?WSDL';

        curl_setopt($curl, CURLOPT_URL, $url);
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 120);
        curl_setopt($curl, CURLOPT_ENCODING, 'gzip');

        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'SOAPAction: ""',
            'Content-Type: text/xml; charset=utf-8',
            'Authorization: Basic cmFmYTpyYWZhZWw=',
        ));

        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $soap);
        
        // XML
        
        $oXML = new SimpleXMLElement(curl_exec($curl));
        curl_close ($curl);
        header( 'Content-type: text/xml' );
        // echo $oXML->asXML();
        
?>