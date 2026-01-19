import psycopg2

# Строка подключения
conn = psycopg2.connect(
    dbname="mydb",
    user="admin",
    password="secret",
    host="localhost",
    port=5432
)

cur = conn.cursor()

# Проверяем таблицу
cur.execute("SELECT * FROM users;")
rows = cur.fetchall()
print("Users in DB:", rows)

cur.close()
conn.close()
