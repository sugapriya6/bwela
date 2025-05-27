package com.example.xmlreader;

import jakarta.servlet.*;
import jakarta.servlet.http.*;
import java.io.*;
import javax.xml.parsers.*;
import org.w3c.dom.*;

public class XMLServlet extends HttpServlet {
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {

        response.setContentType("text/html");
        PrintWriter out = response.getWriter();

        try {
            InputStream input = getServletContext().getResourceAsStream("/data.xml");
            DocumentBuilderFactory factory = DocumentBuilderFactory.newInstance();
            DocumentBuilder builder = factory.newDocumentBuilder();
            Document doc = builder.parse(input);
            doc.getDocumentElement().normalize();

            NodeList list = doc.getElementsByTagName("student");

            out.println("<html><head><title>Students</title>");
            out.println("<style>");
            out.println("body { font-family: Arial, sans-serif; background-color: #f2f2f2; padding: 20px; }");
            out.println("h2 { color: #333; text-align: center; }");
            out.println("table { margin: auto; border-collapse: collapse; width: 60%; background-color: #fff; }");
            out.println("th, td { padding: 12px 15px; border: 1px solid #ddd; text-align: center; }");
            out.println("th { background-color: #4CAF50; color: white; }");
            out.println("tr:nth-child(even) { background-color: #f9f9f9; }");
            out.println("tr:hover { background-color: #f1f1f1; }");
            out.println("</style>");
            out.println("</head><body>");
            out.println("<h2>Student List</h2>");
            out.println("<table><tr><th>Name</th><th>Age</th><th>Course</th></tr>");

            for (int i = 0; i < list.getLength(); i++) {
                Node node = list.item(i);

                if (node.getNodeType() == Node.ELEMENT_NODE) {
                    Element element = (Element) node;

                    String name = element.getElementsByTagName("name").item(0).getTextContent();
                    String age = element.getElementsByTagName("age").item(0).getTextContent();
                    String course = element.getElementsByTagName("course").item(0).getTextContent();

                    out.println("<tr><td>" + name + "</td><td>" + age + "</td><td>" + course + "</td></tr>");
                }
            }

            out.println("</table></body></html>");

        } catch (Exception e) {
            out.println("<p>Error parsing XML: " + e.getMessage() + "</p>");
        }
    }
}
