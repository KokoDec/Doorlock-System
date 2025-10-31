#include <LiquidCrystal_I2C.h>
#include <Keypad.h>
#include <SoftwareSerial.h>

LiquidCrystal_I2C lcd(0x27, 16, 2);
SoftwareSerial espSerial(2, 3); // RX, TX

const byte ROWS = 4;
const byte COLS = 4;
char keys[ROWS][COLS] = {
  {'1', '2', '3', 'A'},
  {'4', '5', '6', 'B'},
  {'7', '8', '9', 'C'},
  {'*', '0', '#', 'D'}
};
byte rowPins[ROWS] = {4, 5, 6, 7};
byte colPins[COLS] = {8, 9, 10, 11};
Keypad keypad = Keypad(makeKeymap(keys), rowPins, colPins, ROWS, COLS);

String inputPassword = "";

void setup() {
  lcd.begin(16, 2);
  lcd.backlight();
  lcd.setCursor(0, 0);
  lcd.print("Enter Password:");
  espSerial.begin(9600);
}

void loop() {
  char key = keypad.getKey();
  if (key) {
    if (key == '#') {
      lcd.clear();
      lcd.print("Verifying...");
      espSerial.println("CHECK:" + inputPassword);
      waitForResponse();
      inputPassword = "";
    } else if (key == '*') {
      inputPassword = "";
      lcd.clear();
      lcd.print("Enter Password:");
    } else {
      inputPassword += key;
      lcd.setCursor(0, 1);
      lcd.print(inputPassword);
    }
  }
}

void waitForResponse() {
  unsigned long startTime = millis();
  while (millis() - startTime < 5000) {
    if (espSerial.available()) {
      String response = espSerial.readStringUntil('\n');
      response.trim();
      lcd.clear();
      if (response == "APPROVED") {
        lcd.print("Access Granted");
        // unlock mechanism here
      } else {
        lcd.print("Access Denied");
      }
      delay(2000);
      lcd.clear();
      lcd.print("Enter Password:");
      break;
    }
  }
}