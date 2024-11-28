<?php
header('Content-Type: application/json');

function getDomainInfo($domain) {
    $result = [];
    
    // IP2WHOIS API integration
    $license_key = 'API KEY';
    $api_url = "https://api.ip2whois.com/v2?key={$license_key}&domain={$domain}";
    
    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    
    if ($response) {
        $whois_data = json_decode($response, true);
        if ($whois_data && isset($whois_data['domain'])) {
            $result['whois'] = [
                'domain' => $whois_data['domain'],
                'create_date' => $whois_data['create_date'],
                'update_date' => $whois_data['update_date'],
                'expire_date' => $whois_data['expire_date'],
                'registrar' => $whois_data['registrar']['name']
            ];
        }
    }
    
    // DNS records
    $result['dns'] = [
        'A' => dns_get_record($domain, DNS_A),
        'MX' => dns_get_record($domain, DNS_MX),
        'NS' => dns_get_record($domain, DNS_NS),
        'TXT' => dns_get_record($domain, DNS_TXT)
    ];
    
    // IP address
    $result['ip'] = gethostbyname($domain);
    
    return $result;
}

function getIpInfo($ip) {
    $result = [];
    
    
    $token = 'TOKEN GIRIN';
    $ip = $_SERVER['REMOTE_ADDR'];
    $api_url = "https://ipinfo.io/{$ip}?token={$token}";
    
    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    
    if ($response) {
        $data = json_decode($response, true);
        if ($data) {
            $loc_parts = explode(',', $data['loc']);
            $result = [
                'ip' => $data['ip'],
                'hostname' => $data['hostname'],
                'city' => $data['city'],
                'region' => $data['region'],
                'country' => $data['country'],
                'latitude' => $loc_parts[0],
                'longitude' => $loc_parts[1],
                'postal' => $data['postal'],
                'timezone' => $data['timezone'],
                'org' => $data['org']
            ];
        }
    }

    
    // Reverse DNS
    $result['hostname'] = gethostbyaddr($ip);
    
    return $result;
}

function scanPorts($ip, $startPort, $endPort) {
    $result = [];
    
    for ($port = $startPort; $port <= $endPort; $port++) {
        $connection = @fsockopen($ip, $port, $errno, $errstr, 1);
        if ($connection) {
            $result[] = [
                'port' => $port,
                'status' => 'open',
                'service' => getservbyport($port, 'tcp')
            ];
            fclose($connection);
        }
    }
    
    return $result;
}

$type = $_POST['type'] ?? '';
$response = ['error' => false, 'data' => null];

try {
    switch ($type) {
        case 'domain':
            $domain = filter_input(INPUT_POST, 'domain', FILTER_SANITIZE_STRING);
            if (!$domain) throw new Exception('Geçerli bir domain giriniz.');
            $response['data'] = getDomainInfo($domain);
            break;
            
        case 'ip':
            $ip = filter_input(INPUT_POST, 'ip', FILTER_VALIDATE_IP);
            if (!$ip) throw new Exception('Geçerli bir IP adresi giriniz.');
            $response['data'] = getIpInfo($ip);
            break;
            
        case 'port':
            $ip = filter_input(INPUT_POST, 'ip', FILTER_VALIDATE_IP);
            $startPort = filter_input(INPUT_POST, 'start_port', FILTER_VALIDATE_INT);
            $endPort = filter_input(INPUT_POST, 'end_port', FILTER_VALIDATE_INT);
            
            if (!$ip) throw new Exception('Geçerli bir IP adresi giriniz.');
            if (!$startPort || !$endPort || $startPort > $endPort) {
                throw new Exception('Geçerli port aralığı giriniz.');
            }
            
            $response['data'] = scanPorts($ip, $startPort, $endPort);
            break;
            
        default:
            throw new Exception('Geçersiz sorgu tipi.');
    }
} catch (Exception $e) {
    $response['error'] = true;
    $response['message'] = $e->getMessage();
}


echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);



