
import mysql.connector
from mysql.connector import Error

def get_connection():
    try:
        connection = mysql.connector.connect(
            host="localhost",
            user="root",
            password="",
            database="proyek_sispak"
        )

        if connection.is_connected():
            print("Koneksi ke database berhasil!")
            return connection

    except Error as e:
        print("Error koneksi ke database:", e)
        return None

if __name__ == "__main__":
    conn = get_connection()
    if conn:
        print("Koneksi berhasil!")
    else:
        print("Koneksi gagal!")