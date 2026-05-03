# 🚗 AlugaCar - Sistema de Aluguel de Veículos

O **AlugaCar** é um sistema completo de aluguel de veículos, composto por:

- 🌐 Site institucional
- 📱 Aplicativo mobile (Flutter)
- 🔌 API backend (PHP)
- 🗄 Banco de dados MySQL em nuvem

O projeto foi desenvolvido como atividade acadêmica com foco em integração entre tecnologias e deploy em ambiente real.

---

## 📌 Funcionalidades

✔ Login de usuário  
✔ Listagem de veículos disponíveis  
✔ Aluguel de veículos  
✔ Cancelamento de aluguel  
✔ Histórico de aluguéis  

---

## 🧱 Arquitetura do Sistema
App / Site
↓
API (PHP - Render)
↓
Banco de Dados (MySQL - Railway)


---

## 🛠 Tecnologias Utilizadas

### Frontend (Site)
- HTML
- CSS
- JavaScript

### Aplicativo Mobile
- Flutter

### Backend (API)
- PHP

### Banco de Dados
- MySQL (Railway)

### Hospedagem
- Render

---

## 🌐 Acesso ao Projeto

### 🔗 API / Site
https://projeto-aplicativo-alugacar-3.onrender.com

### 🔗 Exemplos de endpoints

- Login  
`POST /api/login.php`

- Listar veículos  
`GET /api/listar_carros.php`

- Alugar veículo  
`POST /api/alugar_carro.php`

- Meus aluguéis  
`GET /api/meus_alugueis.php?idcliente=1`

- Cancelar aluguel  
`POST /api/cancelar_aluguel.php`

---

## 📱 Aplicativo

Nome do APK:

alugacar_app.apk

Link para baixar apk 

https://github.com/wellingtontw/Projeto-Aplicativo-alugacar-/releases/tag/1.0 


### 📥 Como instalar

1. Baixar o APK
2. Permitir instalação de fontes desconhecidas
3. Abrir o aplicativo
4. Fazer login com:

CPF: 123
Senha: 123


---

## 🗄 Banco de Dados

Principais tabelas:

- cliente
- veiculo
- alugueis

O banco está hospedado no Railway e integrado à API.

---

## 🚀 Como rodar o projeto localmente

### Backend (PHP)

1. Instalar XAMPP
2. Colocar a pasta `backend` em:

htdocs/

3. Iniciar Apache e MySQL
4. Acessar:

http://localhost/backend/api/listar_carros.php


---

### App Flutter

```bash
flutter pub get
flutter run

alugacar-projeto/
│
├── backend/
│   ├── api/
│   ├── config.php
│   └── imagens/
│
├── app_flutter/
│
├── banco/
│   └── script.sql
│
└── README.md

👥 Integrantes
Wellington Fernandes Marques
Mateus Neves Oliveira
Richard de Oliveira
Guilherme Timpani Santos
Ivamberto Soares de Lima Júnior
Kauê Silva
Patrick Campos

📚 Objetivo do Projeto

Este projeto tem como objetivo demonstrar na prática:

Desenvolvimento Full Stack
Integração entre sistemas
Uso de APIs REST
Deploy em nuvem
Desenvolvimento mobile

📈 Melhorias Futuras
Cadastro de usuários
Upload de imagens
Pagamento online
Dashboard administrativo
