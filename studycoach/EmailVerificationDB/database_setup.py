import sqlite3
import random
import string

# Function to generate a random verification code
def generate_code(length=6):
    return ''.join(random.choices(string.ascii_uppercase + string.digits, k=length))

# Connect to SQLite database (creates 'verification.db' if it doesn't exist)
conn = sqlite3.connect('verification.db')
cursor = conn.cursor()

# Create a table for email verification
cursor.execute('''
    CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY,
        email TEXT UNIQUE NOT NULL,
        first_code TEXT,
        first_verified INTEGER DEFAULT 0,
        second_code TEXT,
        second_verified INTEGER DEFAULT 0
    )
''')

# Function to add a new user
def add_user(email):
    first_code = generate_code()
    cursor.execute('INSERT INTO users (email, first_code) VALUES (?, ?)', (email, first_code))
    conn.commit()
    print(f"User {email} added. First verification code: {first_code}")
    # Simulate sending first email (replace with actual email sending logic)
    send_verification_email(email, first_code, "first")

# Function to verify first code and send second
def verify_first(email, code):
    cursor.execute('SELECT first_code FROM users WHERE email = ?', (email,))
    result = cursor.fetchone()
    if result and result[0] == code:
        second_code = generate_code()
        cursor.execute('UPDATE users SET first_verified = 1, second_code = ? WHERE email = ?', (second_code, email))
        conn.commit()
        print(f"First verification successful for {email}. Second code: {second_code}")
        # Simulate sending second email
        send_verification_email(email, second_code, "second")
    else:
        print("Invalid first verification code.")

# Function to verify second code
def verify_second(email, code):
    cursor.execute('SELECT second_code FROM users WHERE email = ?', (email,))
    result = cursor.fetchone()
    if result and result[0] == code:
        cursor.execute('UPDATE users SET second_verified = 1 WHERE email = ?', (email,))
        conn.commit()
        print(f"Second verification successful for {email}.")
    else:
        print("Invalid second verification code.")

# Simulated email sending function (replace with real SMTP logic, e.g., using smtplib)
def send_verification_email(email, code, step):
    print(f"Simulated {step} verification email sent to {email} with code: {code}")
    # In a real app, use something like:
    # import smtplib
    # server = smtplib.SMTP('smtp.example.com', 587)
    # server.login('your_email', 'your_password')
    # server.sendmail('from@example.com', email, f'Subject: {step.capitalize()} Verification\n\nYour code: {code}')

# Example usage
if __name__ == "__main__":
    # Add a user
    add_user("user@example.com")
    
    # Simulate verifying first code (user provides it)
    verify_first("user@example.com", "ABC123")  # Replace with actual code
    
    # Simulate verifying second code
    verify_second("user@example.com", "XYZ789")  # Replace with actual code
    
    # Close connection
    conn.close()
