from locust import HttpUser, task, between
from bs4 import BeautifulSoup
import random

class SignLearnUser(HttpUser):

    wait_time = between(1, 3)

    huruf = ["a", "b", "c", "d", "e"]

    def on_start(self):

        response = self.client.get("/login")

        soup = BeautifulSoup(response.text, "html.parser")

        token_input = soup.find("input", {"name": "_token"})

        if token_input:

            token = token_input["value"]

            self.client.post(
                "/login",
                data={
                    "_token": token,
                    "login": "EMAIL_ATAU_USERNAME_VALID",
                    "password": "PASSWORD_VALID"
                },
                allow_redirects=True
            )

    @task(3)
    def beranda(self):
        self.client.get("/beranda")

    @task(4)
    def pembelajaran(self):
        modul = random.choice(["bisindo", "sibi"])
        huruf = random.choice(self.huruf)

        self.client.get(
            f"/pembelajaran/{modul}/{huruf}"
        )

    @task(2)
    def latihan(self):
        self.client.get("/latihan")

    @task(1)
    def histori(self):
        self.client.get("/histori")

    @task(1)
    def faq(self):
        self.client.get("/faq")