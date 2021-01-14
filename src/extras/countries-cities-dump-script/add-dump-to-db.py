import json
import mysql.connector
import uuid


def add_countries():
    file = open(
        "C:\\Users\\themg\\PycharmProjects\\Projects-For-Portfolio\\job-portal-project-countries-cities-scrape\\countries\\job-portal-countries-cities.json")
    file_pointer = json.load(file)
    db = mysql.connector.connect(host="localhost", user="root", password="ayanali78941", database="job_portal")
    cursor = db.cursor()
    sql = "INSERT INTO countries (country_code, country_name) VALUES (%s, %s)"
    for i in range(0, len(file_pointer)):
        name = file_pointer[i]["countryName"]
        code = file_pointer[i]["countryCode"]
        print(name)
        values = (code, name)
        cursor.execute(sql, values)
        db.commit()


def add_cities():
    db = mysql.connector.connect(host="localhost", database="job_portal", user="root", password="ayanali78941")
    cursor = db.cursor()
    SQL = "INSERT INTO cities VALUES (country_code, city_code, city_name, city_id) VALUES (%s, %s, %s, %s)"
    file = open("C:\\Users\\themg\\PycharmProjects\\Projects-For-Portfolio\\job-portal-project-countries-cities-scrape\\countries\\job-portal-countries-cities.json")
    json_file_pointer = json.load(file)
    for i in range(0, len(json_file_pointer)):
        country_code = json_file_pointer[i]["countryCode"]
        all_cities = json_file_pointer[i]["cities"]
        for j in range(0, len(all_cities)):
            city_name = all_cities[j]["cityName"]
            city_code = all_cities[j]["cityCode"]
            id_city = str(uuid.uuid4())
            values = (country_code, city_code, city_name, id_city)
            cursor.execute(SQL, values)
