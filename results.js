document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitButton = form.querySelector('button[type="submit"]');
            const originalText = submitButton.innerText;
            submitButton.innerText = 'Sorgulanıyor...';
            submitButton.disabled = true;
            
            try {
                const formData = new FormData(form);
                const response = await fetch('process.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.error) {
                    showError(result.message);
                } else {
                    showResults(result.data, form.querySelector('input[name="type"]').value);
                }
            } catch (error) {
                showError('Bir hata oluştu. Lütfen tekrar deneyin.');
            } finally {
                submitButton.innerText = originalText;
                submitButton.disabled = false;
            }
        });
    });
});

function showResults(data, type) {
    const resultDiv = document.getElementById('results');
    resultDiv.innerHTML = '';
    
    const card = document.createElement('div');
    card.className = 'bg-gray-800 p-6 rounded-lg shadow-xl mt-8 animate-fade-in backdrop-blur-lg bg-opacity-90';
    
    switch (type) {
        case 'domain':
            card.innerHTML = `
                <h3 class="text-2xl font-bold mb-6 flex items-center">
                    <i class="fas fa-globe text-blue-500 mr-3"></i>
                    Domain Bilgileri
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    ${data.whois ? `
                        <div class="bg-gray-700 p-4 rounded-lg">
                            <p class="text-gray-400 flex items-center mb-2">
                                <i class="fas fa-tag text-blue-400 mr-2 w-5"></i>Domain:
                            </p>
                            <p class="text-white ml-7">${data.whois.domain}</p>
                        </div>
                        <div class="bg-gray-700 p-4 rounded-lg">
                            <p class="text-gray-400 flex items-center mb-2">
                                <i class="fas fa-calendar-plus text-green-400 mr-2 w-5"></i>Kayıt Tarihi:
                            </p>
                            <p class="text-white ml-7">${data.whois.create_date}</p>
                        </div>
                        <div class="bg-gray-700 p-4 rounded-lg">
                            <p class="text-gray-400 flex items-center mb-2">
                                <i class="fas fa-clock text-yellow-400 mr-2 w-5"></i>Son Güncelleme:
                            </p>
                            <p class="text-white ml-7">${data.whois.update_date}</p>
                        </div>
                        <div class="bg-gray-700 p-4 rounded-lg">
                            <p class="text-gray-400 flex items-center mb-2">
                                <i class="fas fa-calendar-times text-red-400 mr-2 w-5"></i>Bitiş Tarihi:
                            </p>
                            <p class="text-white ml-7">${data.whois.expire_date}</p>
                        </div>
                        <div class="bg-gray-700 p-4 rounded-lg">
                            <p class="text-gray-400 flex items-center mb-2">
                                <i class="fas fa-building text-purple-400 mr-2 w-5"></i>Registrar:
                            </p>
                            <p class="text-white ml-7">${data.whois.registrar}</p>
                        </div>
                    ` : ''}
                    <div class="bg-gray-700 p-4 rounded-lg">
                        <p class="text-gray-400 flex items-center mb-2">
                            <i class="fas fa-network-wired text-blue-400 mr-2 w-5"></i>IP Adresi:
                        </p>
                        <p class="text-white ml-7">${data.ip}</p>
                    </div>
                </div>
                <div class="mt-6 bg-gray-700 p-4 rounded-lg">
                    <p class="text-gray-400 flex items-center mb-2">
                        <i class="fas fa-server text-green-400 mr-2"></i>DNS Kayıtları:
                    </p>
                    <pre class="text-white overflow-x-auto p-4 bg-gray-800 rounded mt-2">${JSON.stringify(data.dns, null, 2)}</pre>
                </div>
            `;
            break;
            
        case 'ip':
            card.innerHTML = `
                <h3 class="text-2xl font-bold mb-6 flex items-center">
                    <i class="fas fa-network-wired text-blue-500 mr-3"></i>
                    IP Bilgileri
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-700 p-4 rounded-lg">
                        <p class="text-gray-400 flex items-center mb-2">
                            <i class="fas fa-network-wired text-blue-400 mr-2 w-5"></i>IP Adresi:
                        </p>
                        <p class="text-white ml-7">${data.ip}</p>
                    </div>
                    <div class="bg-gray-700 p-4 rounded-lg">
                        <p class="text-gray-400 flex items-center mb-2">
                            <i class="fas fa-globe text-green-400 mr-2 w-5"></i>Ülke:
                        </p>
                        <p class="text-white ml-7">${data.country_name} (${data.country_code})</p>
                    </div>
                    <div class="bg-gray-700 p-4 rounded-lg">
                        <p class="text-gray-400 flex items-center mb-2">
                            <i class="fas fa-map text-yellow-400 mr-2 w-5"></i>Bölge:
                        </p>
                        <p class="text-white ml-7">${data.region_name}</p>
                    </div>
                    <div class="bg-gray-700 p-4 rounded-lg">
                        <p class="text-gray-400 flex items-center mb-2">
                            <i class="fas fa-city text-purple-400 mr-2 w-5"></i>Şehir:
                        </p>
                        <p class="text-white ml-7">${data.city_name}</p>
                    </div>
                    <div class="bg-gray-700 p-4 rounded-lg">
                        <p class="text-gray-400 flex items-center mb-2">
                            <i class="fas fa-location-dot text-red-400 mr-2 w-5"></i>Koordinatlar:
                        </p>
                        <p class="text-white ml-7">${data.latitude}, ${data.longitude}</p>
                    </div>
                    <div class="bg-gray-700 p-4 rounded-lg">
                        <p class="text-gray-400 flex items-center mb-2">
                            <i class="fas fa-clock text-orange-400 mr-2 w-5"></i>Zaman Dilimi:
                        </p>
                        <p class="text-white ml-7">UTC ${data.time_zone}</p>
                    </div>
                    <div class="bg-gray-700 p-4 rounded-lg">
                        <p class="text-gray-400 flex items-center mb-2">
                            <i class="fas fa-building text-indigo-400 mr-2 w-5"></i>AS Bilgisi:
                        </p>
                        <p class="text-white ml-7">${data.as} (ASN: ${data.asn})</p>
                    </div>
                    <div class="bg-gray-700 p-4 rounded-lg">
                        <p class="text-gray-400 flex items-center mb-2">
                            <i class="fas fa-shield-halved text-teal-400 mr-2 w-5"></i>Proxy Durumu:
                        </p>
                        <p class="text-white ml-7">${data.is_proxy ? 'Proxy Tespit Edildi' : 'Proxy Değil'}</p>
                    </div>
                    <div class="bg-gray-700 p-4 rounded-lg">
                        <p class="text-gray-400 flex items-center mb-2">
                            <i class="fas fa-server text-blue-400 mr-2 w-5"></i>Hostname:
                        </p>
                        <p class="text-white ml-7">${data.hostname}</p>
                    </div>
                </div>
            `;
            break;
            
        case 'port':
            card.innerHTML = `
                <h3 class="text-2xl font-bold mb-6 flex items-center">
                    <i class="fas fa-plug text-blue-500 mr-3"></i>
                    Port Tarama Sonuçları
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    ${data.map(port => `
                        <div class="bg-gray-700 p-4 rounded-lg flex items-center">
                            <i class="fas fa-door-open text-green-400 mr-3"></i>
                            <div>
                                <p class="text-white font-semibold">
                                    Port ${port.port}
                                </p>
                                <p class="text-gray-400">
                                    ${port.status.toUpperCase()}
                                    ${port.service ? `(${port.service})` : ''}
                                </p>
                            </div>
                        </div>
                    `).join('')}
                </div>
            `;
            break;
    }
    
    resultDiv.appendChild(card);
}

function showError(message) {
    const resultDiv = document.getElementById('results');
    resultDiv.innerHTML = `
        <div class="bg-red-600 text-white p-4 rounded-lg mt-8 animate-fade-in flex items-center">
            <i class="fas fa-exclamation-circle mr-3"></i>
            <p>${message}</p>
        </div>
    `;
}