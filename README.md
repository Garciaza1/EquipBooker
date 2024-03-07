**Este projeto foi desenvolvido para fazer reservas de salas de aulas com equipamentos eletronicos.**

Para conseguir usar a solução você tera que usar o xampp
**Manual e instalação em video:** https://www.youtube.com/watch?v=i_ypCik4VX0&t=4s&pp=ygURY29tbyBiYWl4YXIgeGFtcHA%3D


Terá que instalar o composer globalmente e reiniciar o computador caso seja windows 
**Manual de instalação em video:** https://www.youtube.com/watch?v=ORmhRph6ChM&pp=ygUVY29tbyBiYWl4YXIgY29tcG9zZXIg


Clone o projeto do github em zip e coloque na pasta htdocs do xampp C:\xampp\htdocs
Abra a pasta do projeto no seu VSCODE ou outra IDE

Abra o xampp e de start no apache e mysql
Clique em admin em ambos
Entre no phpmyadmin 
Então pegue o arquivo na pasta ***BD*** do projeto e importe pra dentro do phpmyadmin, caso de erro por não ter uma base de dados ainda, faça uma com o nome "equipreservs"
Com toda preparação feita e com o composer instalado globalmente de o seguinte comando no terminal na pasta raiz do projeto
```
composser update
```
E então navegue pelas pastas no admin do apache e procure a pasta ***root*** do projeto clique nela e o projeto estará funcionando. 
