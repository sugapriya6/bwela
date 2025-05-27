package com.servlet;
import java.io.IOException;
import java.io.PrintWriter;
import java.sql.*;
import java.util.*;
import jakarta.servlet.ServletException;
import jakarta.servlet.annotation.WebServlet;
import jakarta.servlet.http.*;


public class StudentServlet extends HttpServlet {

    private Connection conn;

    @Override
    public void init() throws ServletException {
        try {
            String url = "jdbc:mysql://localhost:3306/students_db";
            String user = "root";
            String pass = "Hema@5541";

            Class.forName("com.mysql.cj.jdbc.Driver");
            conn = DriverManager.getConnection(url, user, pass);

        } catch (Exception e) {
            throw new ServletException("DB Connection error: " + e.getMessage());
        }
    }

    @Override
    protected void doPost(HttpServletRequest req, HttpServletResponse res)
            throws ServletException, IOException {
        HttpSession session = req.getSession();
        String action = req.getParameter("action");

        try {
            if ("submit_students".equals(action)) {
                PreparedStatement ps = conn.prepareStatement(
                        "INSERT INTO students (name, age, gender, department, dob, district, email, phone, address) " +
                                "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

                ps.setString(1, req.getParameter("name"));
                ps.setInt(2, Integer.parseInt(req.getParameter("age")));
                ps.setString(3, req.getParameter("gender"));
                ps.setString(4, req.getParameter("department"));
                ps.setString(5, req.getParameter("dob"));
                ps.setString(6, req.getParameter("district"));
                ps.setString(7, req.getParameter("email"));
                ps.setString(8, req.getParameter("phone"));
                ps.setString(9, req.getParameter("address"));
                ps.executeUpdate();

            } else if ("filter".equals(action)) {
                String type = req.getParameter("filter_type");
                String value = req.getParameter("filter_value");

                List<String> validFilters = Arrays.asList("name", "gender", "department", "district", "dob");
                if (validFilters.contains(type)) {
                    Map<String, String> filters = (Map<String, String>) session.getAttribute("filters");
                    if (filters == null) filters = new HashMap<>();
                    filters.put(type, value);
                    session.setAttribute("filters", filters);

                    PreparedStatement log = conn.prepareStatement(
                            "INSERT INTO search_logs (filter_type, filter_value) VALUES (?, ?)");
                    log.setString(1, type);
                    log.setString(2, value);
                    log.executeUpdate();
                }

            } else if ("clear_filters".equals(action)) {
                session.removeAttribute("filters");
            }

        } catch (SQLException e) {
            throw new ServletException("Error handling form: " + e.getMessage());
        }

        res.sendRedirect("students");
    }

    @Override
    protected void doGet(HttpServletRequest req, HttpServletResponse res)
            throws ServletException, IOException {
        HttpSession session = req.getSession();
        Map<String, String> filters = (Map<String, String>) session.getAttribute("filters");
        List<Map<String, String>> students = new ArrayList<>();

        try {
            String query = "SELECT * FROM students";
            if (filters != null && !filters.isEmpty()) {
                List<String> where = new ArrayList<>();
                for (Map.Entry<String, String> f : filters.entrySet()) {
                    where.add(f.getKey() + " = '" + f.getValue() + "'");
                }
                query += " WHERE " + String.join(" AND ", where);
            }

            Statement st = conn.createStatement();
            ResultSet rs = st.executeQuery(query);

            while (rs.next()) {
                Map<String, String> row = new LinkedHashMap<>();
                row.put("id", rs.getString("id"));
                row.put("name", rs.getString("name"));
                row.put("age", rs.getString("age"));
                row.put("gender", rs.getString("gender"));
                row.put("department", rs.getString("department"));
                row.put("dob", rs.getString("dob"));
                row.put("district", rs.getString("district"));
                row.put("email", rs.getString("email"));
                row.put("phone", rs.getString("phone"));
                row.put("address", rs.getString("address"));
                students.add(row);
            }

        } catch (SQLException e) {
            throw new ServletException("Error fetching students: " + e.getMessage());
        }

        res.setContentType("text/html");
        PrintWriter out = res.getWriter();

        out.println("<html><head><title>Student Entry</title><style>");
        out.println("body { font-family: Arial, sans-serif; background: #f9f9f9; margin: 0; padding: 0; display: flex; justify-content: center; align-items: flex-start; height: 100vh; }");
        out.println(".container { width: 600px; background: white; padding: 20px; margin-top: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); overflow: auto; max-height: 90vh; }");
        out.println("input, select { width: 100%; padding: 8px; margin: 5px 0; border-radius: 4px; border: 1px solid #ccc; }");
        out.println("table { width: 100%; border-collapse: collapse; margin-top: 20px; table-layout: auto; }");
        out.println("th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }");
        out.println("th { background: #007BFF; color: white; }");
        out.println(".filtered-results { border: 1px solid #007BFF; padding: 15px; background: #f9f9f9; margin-top: 30px; overflow-x: auto; }");
        out.println("</style></head><body>");
        out.println("<div class='container'>");

        out.println("<h2>Student Entry</h2>");
        out.println("<form method='post'>");
        out.println("<input type='hidden' name='action' value='submit_students'/>");
        out.println("Name: <input name='name' required/>");
        out.println("Age: <input type='number' name='age' required/>");
        out.println("Gender: <select name='gender' required><option value=''>Select</option><option>Male</option><option>Female</option></select>");
        out.println("Department: <input name='department' required/>");
        out.println("DOB: <input type='date' name='dob' required/>");
        out.println("District: <input name='district' required/>");
        out.println("Email: <input name='email' required/>");
        out.println("Phone: <input name='phone' required/>");
        out.println("Address: <input name='address' required/>");
        out.println("<input type='submit' value='Add Student'/>");
        out.println("</form>");

        out.println("<h2>Filter Students</h2>");
        out.println("<form method='post'><input type='hidden' name='action' value='filter'/>");
        out.println("Filter Type: <select name='filter_type'><option value=''>Select</option><option>name</option><option>gender</option><option>department</option><option>district</option><option>dob</option></select>");
        out.println("Value: <input name='filter_value'/> <input type='submit' value='Apply Filter'/></form>");

        out.println("<form method='post'><input type='hidden' name='action' value='clear_filters'/>");
        out.println("<input type='submit' value='Clear Filters'/></form>");

        out.println("<h3>Active Filters:</h3>");
        if (filters != null && !filters.isEmpty()) {
            for (Map.Entry<String, String> e : filters.entrySet()) {
                out.println("<p><b>" + e.getKey() + ":</b> " + e.getValue() + "</p>");
            }
        } else {
            out.println("<p>No filters applied.</p>");
        }

        if (!students.isEmpty()) {
            out.println("<div class='filtered-results'>");
            out.println("<h3>Filtered Students</h3><table><tr>");
            for (String key : students.get(0).keySet()) {
                out.println("<th>" + key + "</th>");
            }
            out.println("</tr>");
            for (Map<String, String> row : students) {
                out.println("<tr>");
                for (String val : row.values()) {
                    out.println("<td>" + val + "</td>");
                }
                out.println("</tr>");
            }
            out.println("</table></div>");
        }

        out.println("</div></body></html>");
    }

    @Override
    public void destroy() {
        try {
            if (conn != null) conn.close();
        } catch (SQLException ignored) {}
    }
}
