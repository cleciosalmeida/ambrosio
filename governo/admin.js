   // Selecione o formulário de login
   const loginForm = document.getElementById('loginForm');

   // Adicione um ouvinte de evento de envio ao formulário
   loginForm.addEventListener('submit', function(event) {
       // Impede o envio padrão do formulário
       event.preventDefault();

       // Obtenha os valores dos campos de login e senha
       const login = document.getElementById('loginAdmin').value;
       const password = document.getElementById('passwordAdmin').value;

       // Aqui você pode adicionar sua lógica de validação de login e senha
       // Por exemplo, você pode fazer uma solicitação AJAX para verificar as credenciais no servidor

       // Exemplo de validação simples apenas para fins de demonstração
       if (login === 'admin' && password === 'admin') {
           alert('Login bem-sucedido! Redirecionando...');
           // Redirecione para a página de administração
           window.location.href = '/governo/admin.html'; // Altere o caminho conforme necessário
       } else {
           alert('Login ou senha inválidos. Por favor, tente novamente.');
       }
   });