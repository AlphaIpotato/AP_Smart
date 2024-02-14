const int pwmPin = 11;
int Lux;
void setup() {
  // PWM 핀 설정
  pinMode(pwmPin, OUTPUT);

  // Serial 통신 시작
  Serial.begin(9600);
}

void loop() {
    // PWM 출력 설정
    while (1){
        Lux = 50;
    Serial.print("Power: ");
    Serial.println(Lux);
    analogWrite(pwmPin, Lux);
  delay(1000);

        Lux = 100;
    Serial.print("Power: ");
    Serial.println(Lux);
    analogWrite(pwmPin, Lux);
  delay(1000);

        Lux = 150;
    Serial.print("Power: ");
    Serial.println(Lux);
    analogWrite(pwmPin, Lux);
  delay(1000);

        Lux = 200;
    Serial.print("Power: ");
    Serial.println(Lux);
    analogWrite(pwmPin, Lux);
  delay(1000);

        Lux = 250;
    Serial.print("Power: ");
    Serial.println(Lux);
    analogWrite(pwmPin, Lux);
  delay(1000);

        Lux = 0;
    Serial.print("Power: ");
    Serial.println(Lux);
    analogWrite(pwmPin, Lux);
  delay(1000);
    }
  }

