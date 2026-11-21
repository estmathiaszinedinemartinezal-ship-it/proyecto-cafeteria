namespace CafeteriaMVC.Models
{
    public class Reserva
    {
        public int Id { get; set; }
        public string NombreCliente { get; set; } = "";
        public string Correo { get; set; } = "";
        public DateTime Fecha { get; set; }
        public string Hora { get; set; } = "";
        public int Personas { get; set; }
    }
}