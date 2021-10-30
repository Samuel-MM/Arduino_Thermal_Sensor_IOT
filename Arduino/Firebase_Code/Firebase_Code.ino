#include <ESP8266WiFi.h>
#include <FirebaseArduino.h>

#define FIREBASE_AUTH "insert firebase auth token" 
#define FIREBASE_HOST "insert firebase host without https:// and /"
#define WIFI_SSID "insert your wifi ssid (wifi name)"
#define WIFI_PASSWORD "inser your wifi password"

String values,sensor_data;

void setup() {
  //Initializes the serial connection at 9600 get sensor data from arduino.
   Serial.begin(9600);
   
  delay(1000);
  
  WiFi.begin(WIFI_SSID, WIFI_PASSWORD);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    
  }
  
  Firebase.begin(FIREBASE_HOST, FIREBASE_AUTH); 
  
}
void loop() {

 bool Sr =false;
 
  while(Serial.available()){
    
        //get sensor data from serial put in sensor_data
        sensor_data=Serial.readString(); 
        Sr=true;    
        
    }
  
delay(1000);

  if(Sr==true){  
    
  values=sensor_data;
  //store dht11 sensor data as string in firebase
  Firebase.setString("temperature: ",values);
   delay(2000);
  
  delay(1000);
  
  if (Firebase.failed()) {  
      return;
  }
  
}   
}
