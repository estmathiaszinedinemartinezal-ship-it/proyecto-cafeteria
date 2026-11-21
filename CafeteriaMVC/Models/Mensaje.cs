namespace CafeteriaMVC.Models
{
    public class Mensaje
    {
        public int Id { get; set; }
        public string Nombre { get; set; } = "";
        public string Correo { get; set; } = "";
        public string Texto { get; set; } = "";
        public DateTime FechaEnvio { get; set; }
    }
}