<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>JOVEMLINK - Notificações</title>
  <link rel="stylesheet" href="notificacoes.css">
</head>
<body>

  <!-- Topbar / Cabeçalho -->
  <header class="topbar">
    <div class="logo">JOVEMLINK</div>
    <nav class="top-nav">
      <a href="login-candidato.html">LOGIN - CANDIDATO</a>
      <a href="login-empresa.html">LOGIN - EMPRESA</a>
      <a href="perfil-candidato.html">PERFIL DO CANDIDATO</a>
    </nav>
  </header>

  <div class="main-container">
    
    <!-- Sidebar / Menu Lateral -->
    <aside class="sidebar">
      <ul>
        <li>
          <a href="inicio.html">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
            Início
          </a>
        </li>
        <li>
          <a href="curriculo.html">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
            Meu currículo
          </a>
        </li>
        <li>
          <a href="oportunidades.html">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
            Oportunidades
          </a>
        </li>
        <li class="active">
          <a href="notificacoes.html">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
            Notificações
          </a>
        </li>
        <li>
          <a href="dicas.html">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18h6"></path><path d="M10 22h4"></path><path d="M15.09 14c.18-.98.65-1.74 1.41-2.5A4.65 4.65 0 0 0 18 8 6 6 0 0 0 6 8c0 1 .23 2.23 1.5 3.5A4.61 4.61 0 0 1 8.91 14"></path></svg>
            Dicas
          </a>
        </li>
        <li>
          <a href="perfil.html">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
            Perfil
          </a>
        </li>
      </ul>

      <div class="logout">
        <a href="login.html">
          <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
          Sair
        </a>
      </div>
    </aside>

    <!-- Conteúdo Principal da Aba Notificações -->
    <main class="content">
      <div class="header-section">
        <div>
          <h1>Notificações</h1>
          <p class="subtitle">Fique por dentro das novidades e oportunidades que aparecem para você.</p>
        </div>
        <div class="filter-dropdown">
          <select>
            <option>Todas as notificações</option>
          </select>
        </div>
      </div>

      <!-- Lista de Notificações -->
      <div class="notifications-list">

        <!-- Item 1 -->
        <div class="notification-card unread">
          <div class="unread-dot"></div>
          <div class="avatar logo-giraffas">Giraffas</div>
          <div class="info">
            <h2>Nova vaga disponível</h2>
            <p>Giraffas está com vagas abertas para Atendente de Restaurante.</p>
            <span class="time">Há 15 minutos</span>
          </div>
          <button class="btn-action">Ver vaga</button>
        </div>

        <!-- Item 2 -->
        <div class="notification-card unread">
          <div class="unread-dot"></div>
          <div class="avatar logo-ca">C&A</div>
          <div class="info">
            <h2>Empresa demonstrou interesse no seu perfil</h2>
            <p>A C&A visualizou seu currículo e pode entrar em contato em breve.</p>
            <span class="time">Há 1 hora</span>
          </div>
          <button class="btn-action">Ver empresa</button>
        </div>

        <!-- Item 3 -->
        <div class="notification-card unread">
          <div class="unread-dot"></div>
          <div class="avatar logo-mc">M</div>
          <div class="info">
            <h2>Convite para processo seletivo</h2>
            <p>A McDonald's convidou você para participar de um processo seletivo.</p>
            <span class="time">Há 2 horas</span>
          </div>
          <button class="btn-action">Ver detalhes</button>
        </div>

        <!-- Item 4 -->
        <div class="notification-card">
          <div class="unread-dot hidden"></div>
          <div class="avatar logo-renner">R</div>
          <div class="info">
            <h2>Vaga próxima ao seu perfil</h2>
            <p>A Renner publicou uma vaga que combina com o seu perfil.</p>
            <span class="time">Ontem</span>
          </div>
          <button class="btn-action">Ver vaga</button>
        </div>

        <!-- Item 5 -->
        <div class="notification-card">
          <div class="unread-dot hidden"></div>
          <div class="avatar logo-magalu">magalu</div>
          <div class="info">
            <h2>Atualização de candidatura</h2>
            <p>Seu currículo foi atualizado com sucesso para a vaga de Jovem Aprendiz.</p>
            <span class="time">2 dias atrás</span>
          </div>
          <button class="btn-action">Ver candidatura</button>
        </div>

        <!-- Item 6 -->
        <div class="notification-card">
          <div class="unread-dot hidden"></div>
          <div class="avatar logo-tip">★</div>
          <div class="info">
            <h2>Dica para você</h2>
            <p>Complete seu currículo para aumentar suas chances de conseguir uma vaga.</p>
            <span class="time">3 dias atrás</span>
          </div>
          <button class="btn-action">Completar currículo</button>
        </div>

      </div>
    </main>

  </div>

</body>
</html>