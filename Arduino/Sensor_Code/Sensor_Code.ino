//DHT sensor library
#include "DHT.h"

const int pino_dht = 9; // pin where dht is connected
float temperatura; // variable for temperature
DHT dht(pino_dht, DHT11); // sets the pin and dht as it's type
String values;

void setup() {
  Serial.begin(9600); 

  dht.begin(); // starts sensor
}

void loop() {
  delay(2000); // 2 seconds (Datasheet value)

  temperatura = dht.readTemperature(); // get temperature (ºC)
  
  // If there's an error
  if (isnan(umidade) || isnan(temperatura)) {
    Serial.println("Falha na leitura do Sensor DHT!");
  }
  else { // Else (if everything is ok)
    values = temperatura;
    delay(1000);  
    //Show temperature
    Serial.print(values);
    //Line break
    Serial.println();
  }
}
