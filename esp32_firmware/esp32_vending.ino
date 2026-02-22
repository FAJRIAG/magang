#include <WiFi.h>
#include <HTTPClient.h>
#include <ArduinoJson.h>
#include "mbedtls/md.h"

// WiFi Configuration
const char* ssid = "YOUR_SSID";
const char* password = "YOUR_PASSWORD";

// API Configuration
const char* serverUrl = "http://YOUR_SERVER_IP:8889/api/tap";
const char* deviceId = "VM01";
const char* secretKey = "YOUR_DEVICE_SECRET_KEY";

// Pin Configuration
const int relayPin = 2; // GPIO connected to Relay

// Mock RFID Reader (Replace with actual MFRC522 logic later)
// For testing, send UID via Serial Monitor
String readRFID() {
  if (Serial.available()) {
    String uid = Serial.readStringUntil('\n');
    uid.trim();
    if (uid.length() > 0) return uid;
  }
  return "";
}

// Helper to convert byte array to hex string
String toHexString(byte* buffer, size_t length) {
  String hexString = "";
  for (size_t i = 0; i < length; i++) {
    if (buffer[i] < 16) hexString += "0";
    String byteHex = String(buffer[i], HEX);
    byteHex.toUpperCase();
    hexString += byteHex;
  }
  return hexString;
}

// Compute HMAC SHA256
String computeHMAC(String data, String key) {
  byte hmacResult[32];
  mbedtls_md_context_t ctx;
  mbedtls_md_type_t md_type = MBEDTLS_MD_SHA256;

  mbedtls_md_init(&ctx);
  mbedtls_md_setup(&ctx, mbedtls_md_info_from_type(md_type), 1);
  mbedtls_md_hmac_starts(&ctx, (const unsigned char*)key.c_str(), key.length());
  mbedtls_md_hmac_update(&ctx, (const unsigned char*)data.c_str(), data.length());
  mbedtls_md_hmac_finish(&ctx, hmacResult);
  mbedtls_md_free(&ctx);

  return toHexString(hmacResult, 32);
}

void setup() {
  Serial.begin(115200);
  pinMode(relayPin, OUTPUT);
  digitalWrite(relayPin, LOW);

  // Connect to WiFi
  WiFi.begin(ssid, password);
  Serial.print("Connecting to WiFi");
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("\nConnected!");
  Serial.print("IP Address: ");
  Serial.println(WiFi.localIP());
}

void loop() {
  String rfidUid = readRFID();
  
  if (rfidUid != "") {
    Serial.println("RFID Detected: " + rfidUid);

    if (WiFi.status() == WL_CONNECTED) {
      HTTPClient http;
      http.begin(serverUrl);
      http.addHeader("Content-Type", "application/json");
      http.addHeader("Accept", "application/json");

      // Sign the RFID UID
      // Ensure the server uses the same string for signature verification
      // Here we sign just the UID as per our plan
      String signature = computeHMAC(rfidUid, secretKey); 
      // Note: If you want to sign payload, construct payload string first. 
      // But implementation plan assumed checking signature of RFID using secret key.

      // Create JSON payload
      // Using ArduinoJson (install library via Library Manager)
      StaticJsonDocument<200> doc;
      doc["rfid_uid"] = rfidUid;
      doc["device_id"] = deviceId;
      doc["signature"] = signature;

      String requestBody;
      serializeJson(doc, requestBody);

      Serial.println("Sending Request: " + requestBody);
      int httpResponseCode = http.POST(requestBody);

      if (httpResponseCode > 0) {
        String response = http.getString();
        Serial.println("Response Code: " + String(httpResponseCode));
        Serial.println("Response: " + response);

        StaticJsonDocument<512> responseDoc;
        DeserializationError error = deserializeJson(responseDoc, response);

        if (!error) {
          const char* status = responseDoc["status"];
          
          if (String(status) == "ALLOW") {
            Serial.println("Access GRANTED. Dispensing...");
            int duration = responseDoc["duration"] | 3000;
            digitalWrite(relayPin, HIGH);
            delay(duration);
            digitalWrite(relayPin, LOW);
            Serial.println("Done.");
          } else {
            const char* reason = responseDoc["reason"];
            Serial.println("Access DENIED: " + String(reason));
          }
        } else {
          Serial.print("deserializeJson() failed: ");
          Serial.println(error.c_str());
        }

      } else {
        Serial.print("Error on sending POST: ");
        Serial.println(httpResponseCode);
      }

      http.end();
    } else {
      Serial.println("WiFi Disconnected");
    }
  }
  
  // Basic loop delay
  delay(100);
}
