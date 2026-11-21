namespace CafeteriaMVC.Models
{
    public class EstadisticaCategoria
    {
        public string Categoria { get; set; } = "";
        public int Cantidad { get; set; }
        public decimal Promedio { get; set; }
        public decimal Maximo { get; set; }
        public decimal Minimo { get; set; }
    }

    public class EstadisticasViewModel
    {
        public int TotalProductos { get; set; }
        public int TotalReservas { get; set; }
        public int TotalMensajes { get; set; }
        public decimal PrecioPromedio { get; set; }
        public double PromedioPersonas { get; set; }
        public decimal PrecioMaximo { get; set; }
        public decimal PrecioMinimo { get; set; }
        public int TotalComensales { get; set; }
        public List<EstadisticaCategoria> PorCategoria { get; set; } = new();
    }
}