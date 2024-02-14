#include "DHT.h"

#define DHTPIN 16      // DHT22 센서의 데이터 핀
#define DHTTYPE DHT22  // DHT22 센서 사용
#define SOIL_MOISTURE_PIN 0 // 토양습도 센서를 아두이노의 아날로그 핀 A0에 연결


DHT dht(DHTPIN, DHTTYPE);

void setup() {
  Serial.begin(9600);
  Serial.println("DHT22 예제");

  dht.begin();  // DHT 센서 초기화
}

void loop() {
  delay(1000);  // 1초마다 측정

  float humidity = dht.readHumidity();    // 습도 읽기
  float temperature = dht.readTemperature();  // 온도 읽기 (섭씨)

  int soilMoisture = analogRead(SOIL_MOISTURE_PIN); // 토양습도 값 읽기
  // 토양습도 센서가 0에서 1023까지의 값을 제공한다고 가정하며, 실제 센서의 사양에 따라 조정이 필요할 수 있습니다.

  // DHT22에서 온습도 값을 읽은 후 시리얼 모니터에 출력
  Serial.print("습도: ");
  Serial.print(humidity);
  Serial.print("%, ");

  Serial.print("온도: ");
  Serial.print(temperature);
  Serial.println("°C");

  // 토양습도 읽기
  Serial.print("토양습도: ");
  Serial.println(soilMoisture);
}
