package com.example;

import jakarta.servlet.*;
import jakarta.servlet.http.*;
import java.io.*;

public class RegisterServlet extends HttpServlet {

    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        response.setContentType("text/html");
        PrintWriter out = response.getWriter();
        
        out.println("<!DOCTYPE html>");
        out.println("<html>");
        out.println("<head>");
        out.println("<title>Registration Form</title>");
        out.println("<style>");
        out.println("body {");
        out.println("    font-family: Arial, sans-serif;");
        out.println("    background-color: #f0f0f0;");
        out.println("    display: flex;");
        out.println("    justify-content: center;");
        out.println("    align-items: center;");
        out.println("    height: 100vh;");
        out.println("    margin: 0;");
        out.println("}");
        out.println(".form-box {");
        out.println("    background-color: white;");
        out.println("    padding: 30px;");
        out.println("    border-radius: 10px;");
        out.println("    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);");
        out.println("    width: 300px;");
        out.println("}");
        out.println("input[type='text'], input[type='email'], input[type='password'] {");
        out.println("    width: 100%;");
        out.println("    padding: 8px;");
        out.println("    margin: 8px 0;");
        out.println("    box-sizing: border-box;");
        out.println("}");
        out.println("button {");
        out.println("    width: 100%;");
        out.println("    padding: 10px;");
        out.println("    background-color: #28a745;");
        out.println("    color: white;");
        out.println("    border: none;");
        out.println("    border-radius: 5px;");
        out.println("    cursor: pointer;");
        out.println("}");
        out.println("button:hover {");
        out.println("    background-color: #218838;");
        out.println("}");
        out.println("</style>");
        out.println("</head>");
        out.println("<body>");
        out.println("<div class='form-box'>");
        out.println("<h2>Register</h2>");
        out.println("<form action='register' method='POST'>");
        out.println("<label for='name'>Name:</label>");
        out.println("<input type='text' id='name' name='name' required>");
        out.println("<label for='email'>Email:</label>");
        out.println("<input type='email' id='email' name='email' required>");
        out.println("<label for='password'>Password:</label>");
        out.println("<input type='password' id='password' name='password' required>");
        out.println("<button type='submit'>Register</button>");
        out.println("</form>");
        out.println("</div>");
        out.println("</body>");
        out.println("</html>");
    }

    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        String name = request.getParameter("name");
        String email = request.getParameter("email");
        String password = request.getParameter("password");

        response.setContentType("text/html");
        PrintWriter out = response.getWriter();

        out.println("<!DOCTYPE html>");
        out.println("<html>");
        out.println("<head><title>Registration Success</title>");
        out.println("<style>");
        out.println("body { font-family: Arial, sans-serif; padding: 20px; background-color: #e0ffe0; }");
        out.println(".success-box { background: white; padding: 20px; border-radius: 10px; max-width: 400px; margin: auto; box-shadow: 0 0 10px rgba(0,0,0,0.1); }");
        out.println("</style>");
        out.println("</head>");
        out.println("<body>");
        out.println("<div class='success-box'>");
        out.println("<h2>Registration Successful!</h2>");
        out.println("<p><strong>Name:</strong> " + name + "</p>");
        out.println("<p><strong>Email:</strong> " + email + "</p>");
        out.println("<p><strong>Password:</strong> " + password + "</p>"); // Note: In real apps, don't display password
        out.println("</div>");
        out.println("</body>");
        out.println("</html>");
    }
}
