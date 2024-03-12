using System;
using System.IO;
using System.Management;
using System.Net;
using System.Net.Http;
using Newtonsoft;
using System.Web;
using System.Threading.Tasks;
using System.Text;

namespace AXAJ_C__Client
{
    internal class Program
    {
        static void Main(string[] args)
        {
            Console.WriteLine("Hello World!");
          //  httpclient_POST();

            Console.ReadKey();
        }

        public static async Task httpclient_POST()
        {
            string url = "http://test-ajaxclient-neverless.xyz/interface/api/interface.php/test";

            DateTime currentDate = DateTime.Now;
            string formattedDate = currentDate.ToString("yyyy-MM-dd");

          HttpClient client = new HttpClient();
            string jsonBody = $"{{\"Date\":\"{formattedDate}\"}}";

            var postData = new StringContent(jsonBody, Encoding.UTF8, "application/json");
            HttpResponseMessage response = await client.PostAsync(url, postData) ;
            string responseBody = await response.Content.ReadAsStringAsync();
            Console.WriteLine(responseBody);

            client.Dispose();
        }

        public static async Task httpclient_GET()
        {
            string url = "http://test-ajaxclient-neverless.xyz/interface/api/interface.php/test";

            DateTime currentDate = DateTime.Now;
            string formattedDate = currentDate.ToString("yyyy-MM-dd");

            HttpClient client = new HttpClient();
            string newurl = url + $"{{\"Date\":\"{formattedDate}\"}}";
            HttpResponseMessage response = await client.GetAsync(url);
            if (response.IsSuccessStatusCode)
            {
                string responseBody = await response.Content.ReadAsStringAsync();
                Console.WriteLine(responseBody);
            }
            else
            {
                Console.WriteLine("Error: " + response.StatusCode);
            }
            client.Dispose();
        }

        public static async Task httpclient_Delete()
        {
            string url = "http://test-ajaxclient-neverless.xyz/interface/api/interface.php/test";

            DateTime currentDate = DateTime.Now;
            string formattedDate = currentDate.ToString("yyyy-MM-dd");

            HttpClient client = new HttpClient();
            string newurl = url + $"{{\"Date\":\"{formattedDate}\"}}";
            HttpResponseMessage response = await client.DeleteAsync(url);
            if (response.IsSuccessStatusCode)
            {
                string responseBody = await response.Content.ReadAsStringAsync();
                Console.WriteLine(responseBody);
            }
            else
            {
                Console.WriteLine("Error: " + response.StatusCode);
            }
            client.Dispose();
        }
        public static async Task httpclient_PUT()
        {
            //Update the time and order by time
            string url = "http://test-ajaxclient-neverless.xyz/interface/api/interface.php/test";

            DateTime currentDate = DateTime.Now;
            string formattedDate = currentDate.ToString("yyyy-MM-dd");

            HttpClient client = new HttpClient();
            string newurl = url + $"{{\"Date\":\"{formattedDate}\"}}";
            HttpResponseMessage response = await client.GetAsync(url);
            if (response.IsSuccessStatusCode)
            {

                string jsonBody = $"{{\"Date\":\"{formattedDate}\"}}";

                var putData = new StringContent(jsonBody, Encoding.UTF8, "application/json");
                HttpClient newclient = new HttpClient();
                HttpResponseMessage newresponse = await newclient.PutAsync(url, putData);
                string responseBody = await newresponse.Content.ReadAsStringAsync();
                Console.WriteLine(responseBody);
                newclient.Dispose();
            }
            else
            {
                Console.WriteLine("Error: " + response.StatusCode);
            }
            client.Dispose();
        }
    }
}
